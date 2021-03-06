<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;

use frontend\models\ContactForm;
use frontend\models\ProfilePage;
use frontend\models\ManagerGift;
use frontend\models\Bank;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }


    public function actionProfile() {
    	
    	$getAll = ProfilePage::getAll();
    	$getGift = ProfilePage::getGift();


    	return $this->render('profile',[
            'getAll' => $getAll,
            'getGift' => $getGift,
        ]);
    }

	public function actionManager() {
    	$getGift = ManagerGift::getGift();

    	return $this->render('managergift',[
            'getGift' => $getGift,
        ]);
    }

    public function actionBank() {
		$bankAll = Bank::getBank();

    	return $this->render('bank',[
            'bankAll' => $bankAll,
        ]);
    }


	/**?????????????? ?????????? + ???????????? ?????? ???????????????????? ???? ?????? ?????????? **/
	public function actionGiftajax() {
		if(\Yii::$app->request->isAjax) {
			$command = (new \yii\db\Query())
			->from('gift')
			->where(['not in','quantity',[0]])
			->orderBy('RAND()')
			->limit(1)
			->createCommand();
			
			$res = $command->queryOne();
			$rndQuantity = 1;

			switch($res['type']) {
				case 1: 
					$rndQuantity = rand(1,100);
					$res['value'] = $rndQuantity;
					break;
				case 2:
					$rndQuantity = rand(1,500);
					$res['value'] = $rndQuantity;
					break;
				default:
					$res['value'] = $rndQuantity;
			}
			
			if(!empty($res)) {
				unset($_COOKIE['idGift']);
				unset($_COOKIE['quantity']);
				
				setcookie("idGift", $res['id']);
				setcookie("quantity", $res['value']);
				setcookie("typeGift", $res['type']);

				return json_encode($res);
			} else {
				return false;
			}
		}

	}

    public function actionSendusergift() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['idGift'])) {
    			$idGift = (int)$_COOKIE['idGift'];

				$address = isset($_POST['address']);
				if($address)
					$address = $_POST['address'];
				

				$quantity = (int)$_COOKIE['quantity'];
				$typeGift = (int)$_COOKIE['typeGift'];
				
				$userID = Yii::$app->user->identity->id;

				$command = (new \yii\db\Query())
					->select('quantity')
					->from('gift')
					->where(['id' => $idGift])
					->createCommand();
				$res = $command->queryOne();
				$resQuantity = $res['quantity'];

				
				$transaction = Yii::$app->db->beginTransaction();

				if($resQuantity > 0 && $idGift != 2) {
					$sum = $resQuantity - 1;
					$updateQuantity = Yii::$app->db->createCommand()
						->update('gift', array('quantity' => $sum),'id = :id', array(':id'=> $idGift))
						->execute();
				}
				

				$send = ($idGift == 2) ? 1 : 0;
	    		$addGift = Yii::$app->db->createCommand()->insert('user_has_gift', [
																		'gift_id' => $idGift,
																		'user_id' =>  $userID,
																		'send' => $send,
																		'quantity' => $quantity
																		])->execute();
                $hasGiftId = Yii::$app->db->getLastInsertID(); 

				if($typeGift == 2)	{													
					$this->updateUserWallet($typeGift, $userID, $quantity);
				} 
                if($typeGift == 3) {
					$this->addAdresSend($userID,$idGift,$address,$hasGiftId);
				}

				if($addGift) {
					$transaction->commit();
					
					unset($_COOKIE['idGift']);
					unset($_COOKIE['quantity']);
					unset($_COOKIE['typeGift']);

					return json_encode(array('result'=>'successfully'));
				} else {
					$transaction->rollback();
					return false;
				}
    		}
    		else {
    			return 'error';
    		}
    	}
    }

	public function updateUserWallet($typeGift, $userID, $quantity) {

		/*if($typeGift == 1) {
			$column = 'cash';
			$balance = Yii::$app->user->identity->cash;
		} else {
			$column = 'Points';
			$balance = Yii::$app->user->identity->Points;
		}*/		
        $column = 'Points';
        $balance = Yii::$app->user->identity->Points;

		$transaction = Yii::$app->db->beginTransaction();

		$updateQuantity = Yii::$app->db->createCommand()
						->update('user', array($column => $balance + $quantity),'id = :id', array(':id'=> $userID))
						->execute();

		if($updateQuantity) {
			$transaction->commit();
		} else {
			$transaction->rollback();
			return false;
		}
	}

	public function addAdresSend($userID,$idGift,$address,$hasGiftId) {
		$transaction = Yii::$app->db->beginTransaction();

		$addAdressGift = Yii::$app->db->createCommand()->insert('adress_user', [
			'id_gift' => $idGift,
			'id_user' =>  $userID,
            'userhasgift_id' =>  $hasGiftId,
			'address' => $address
		])->execute();

		if($addAdressGift) {
			$transaction->commit();
		} else {
			$transaction->rollback();
			return false;
		}	
	}
	/**?????????? */
	
	/**?????????????????????? ???????????? ?? ?????????????????? ???????????? ???????????????? ?? ?????? **/
    public function actionConvertcurrency() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['value']) && isset($_POST['name'])) {

    			$userID = Yii::$app->user->identity->id;
				$name = strtolower($_POST['name']);
				$value = $_POST['value'];
				$error = false;

				$Poins = Yii::$app->user->identity->Points;
				$Cash = Yii::$app->user->identity->cash;

				switch($name) {
					case 'points':
						$getSum = $value * 10;	
						$sumPoint = $Poins - $getSum;
    					$sumCash = $Cash + $value;
						$error = ($getSum > $Poins) ? true : false;
						break;
					case 'cash':
						$getSum = $value / 10;
						$sumPoint = $Poins + $value;
    					$sumCash = $Cash - $getSum;	
						$error = ($getSum > $Cash) ? true : false;
						break;	
				}
				
    			if($error) {
    				return 'Enter to correct value!';
    			}
    			else {
					$transaction = Yii::$app->db->beginTransaction();

					$updateQuantity = Yii::$app->db->createCommand()
									->update(
										'user', array('cash' => $sumCash, 'Points' => $sumPoint),
										'id = :id', array(':id'=> $userID)
									)->execute();
			
					if($updateQuantity) {
						$transaction->commit();
						return 'Operation completed successfully';
					} else {
						$transaction->rollback();
						return false;
					}
	    			
    			}

    			
    		}
    	} 
    }

    public function actionBanksend() {
    	if(\Yii::$app->request->isAjax) {
            return 'bank';
    	}
    }
	/** ?????????? **/

    /**???????????????? ?????????????? ???? ?????????? ?????????????????????? - ?????? ???????????????????????? ?????????????? ????????????????????**/
    public function actionTobank() {
        if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['cash'])) {
                $cash = $_POST['cash'];
                $balance = Yii::$app->user->identity->cash;
                $userID = Yii::$app->user->identity->id;
                $userName = Yii::$app->user->identity->username;

                if($balance >= $cash) {
                    $addTransaction = Yii::$app->db->createCommand()->insert('transaction_bank', [
                        'id_user' => $userID,
                        'money' =>  $cash,
                        'name' => $userName
                    ])->execute();
                    
                    if($addTransaction) {
                        return json_encode(array('result'=>'successfully'));
                    }

                } else {
                    return json_encode(array('error'=>'error'));
                }
            }
        }
    }
    
    public function actionSnedgiftmail() {
        if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['hasGiftId'])) {
                //$idSend = $_POST['id']; ?????????? ???????????????? ?????????????????????? ???????????????? zip ???????? ???? ?????????? ?????? ???????????? ?? ???????????? ???????????? ???????????? ??????????????
                $hasGiftId = $_POST['hasGiftId'];
                
                $transaction = Yii::$app->db->beginTransaction();

                $updateStatus = Yii::$app->db->createCommand()
                                ->update('user_has_gift', array('send' => 1),'id = :id', array(':id'=> $hasGiftId))
                                ->execute();
        
                if($updateStatus) {
                    $transaction->commit();
                    return json_encode(array('result'=>'successfully'));
                } else {
                    $transaction->rollback();
                    return false;
                }

            } else {
                return json_encode(array('error'=>'error post data'));
            }
        } else {
            return json_encode(array('error'=>'ajax error'));
        }
    }
}
