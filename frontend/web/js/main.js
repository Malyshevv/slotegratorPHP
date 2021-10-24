window.getCookie = function(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
}

$("body").on('click','#giftBtn',function() {
    $('.jumbotron').fadeOut('fast');
    $('#loading').fadeIn('fast');
    $('#gift').empty();

    $.ajax({
        type:'post',
        url: './giftajax',
        success:function(data){
            var data = JSON.parse(data)
            if(data) {
                var htmlModal = null
                var defaultBtn = '<span id="GetFinalGift" class="btn btn-info">Get gift</span>';
                var modalBtn = '<span class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Get gift</span>'
                var iconCurrency = (data.type == 1) ? data.value + '$' : data.value + '₿';

                if(data.type == '3') {
                    htmlModal = `<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">${data.name}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <center>
                                    <h1>Congratulations, you get free </h1><br> <br>
                                    <img style="width: 150px;" src="${data.img}"> 	
                                    <br><br>
                                    <h3>${data.name}</h3><br>
                                    <form>
                                        <label for="address">Enter your address</label>
                                        <input type="text" name="address" class="form-control" id="location" required>
                                        <br>
                                        <span id="GetFinalGift" class="btn btn-info" style="margin-top:10px;">Send!</span>
                                    </form>
                                </center>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>
                            
                            <script>
                                var placesAutocomplete = places({
                                    appId: "plY7RVZO7INN",
                                    apiKey: "b4f778c77e5f84515f5d40a28ce7ee71",
                                    container: document.querySelector("#location")
                                });
                            </script>`
                    $('#gift').append(htmlModal);
                }
                
                var htmlMain = `<center>
                                    <h1>Congratulations, you get free </h1><br> <br>
                                    <img style="width: 150px;" src="${data.img}"> 
                                    <br><br>
                                    <h3>${data.name} 
                                        ${(data.type != '3') ? '-' + iconCurrency : ''}
                                    </h3><br>
                                    ${(data.type != '3') ? defaultBtn : modalBtn}
                                    <span id="giftBtn" class="btn btn-danger">Refuse and try luck again</span>
                                </center>`

                $('#loading').fadeOut('fast');
                $('#gift').append(htmlMain);
            }
        }
    });
});


$("body").on("click", '#GetFinalGift',function() {
    var idGift = getCookie('idGift');
    var quantity = getCookie('quantity');
    var typeGift = getCookie('typeGift');
    var address = ($('#location') ? $('#location').val() : null);
    var params = null;

    if(typeGift != '3') { 
        params = {'idGift': idGift, 'quantity': quantity, 'typeGift': typeGift}
    } else {
        params = {'idGift': idGift, 'quantity': quantity, 'typeGift': typeGift, 'address': address}
    }
    
    $.ajax({
        type:'post',
        url: './sendusergift',
        data: params,
        success:function(data){
            var data = JSON.parse(data)
            if(data.result == 'successfully') {
                window.location.href = "/profile";
            } else {
                alert('error - check console and network')
                console.log(data)
            }
        }
    });
});



/*PROFILE EVENT*/
$('input[type="checkbox"]').prop('checked', false);
var balance = null;
var nameCurrency = null;
var type = null;
var sum = null;
var ration = null;
var error = false;

$('#convertcash').click(function() {
    if (this.checked) {
        $('input[type="checkbox"]').not(this).prop('checked', false);
        $('#convert').val('');
        $('#yourGet').empty();
        
        nameCurrency = $(this).attr('name');
        balance = $(this).attr('balance');
        type = 1;
        ratio = 10;
    } else {
        $('#convert').val('');
        $('#yourGet').empty();
    }
});

$('#convertpoint').click(function() {
    if (this.checked) {
        $('input[type="checkbox"]').not(this).prop('checked', false);
        $('#convert').val('');
        $('#yourGet').empty();

        nameCurrency = $(this).attr('name');
        balance = $(this).attr('balance');
        type = 2;
        ratio = 0.10;
    } else {
        $('#convert').val('');
        $('#yourGet').empty();
    }
});

$('#convert').on('keyup',function(){
    var value = $(this).val()
    var error = (parseInt(balance) < parseInt(value)) ? true : false;
    sum = value * ratio

    if(error) {
        $('.cashConvert').attr("disabled", "disabled");
        return false;
    } else {
        $('.cashConvert').removeAttr('disabled')
        $('#sumConvert').val(sum)
    }

    $('#yourGet').empty();
    $('#yourGet').append(sum);
});

$('.cashConvert').click(function() {
    console.log(error)
    if(!error) {
        $.ajax({
            type:'post',
            url: './convertcurrency',
            data: {'value': sum , 'name': nameCurrency},
            success:function(data){
                alert(data)
                document.location.reload(true);
            }
        });
        }
});

