window.onload = function (){
    var temp= document.getElementsByClassName('MODE');

    for (i=0;i<temp.length;i++){
        temp[i].style.display='none';
    }
    document.getElementById('a').style.display='block'
}

document.getElementById("mode").addEventListener('change',function (){

    var temp= document.getElementsByClassName('MODE');

    for (i=0;i<temp.length;i++){
        temp[i].style.display='none';
    }

    document.getElementById(this.value).style.display='block'
})

$(document).ready(function(){
    $("#submit").click(function(){
        var mode= $("#mode").val();
        if ( mode === 'a') {

            var d= $("#datum").val();
            var countr= $("#country").val();
            var afterDot = d.substr(d.indexOf('-')+1);
            var day2= afterDot.slice(-2)
            var month = afterDot.slice(0,2)

            if (afterDot[0] === '0'){
                afterDot = d.substr(d.indexOf('-')+2);
                month = afterDot.slice(0,1)
            }

            $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?day='+ day2 +'&mo=' + month+ '&co=' + countr +'',
                success: function (data) {

                    var responsedata = $.parseJSON(data);

                    var length=responsedata.length;

                    $("#finalDiv").html('');
                    for (i=parseInt(length) ; i!==0; i--){
                        $("#finalDiv").append( 'Meno: '+responsedata[i-1]+ '<br>')   ;
                    }
                }
            });
        }
        if ( mode === 'b') {
            var NEV= document.getElementById('nev').value
            var countr= $("#country2").val();

            console.log(countr);
            $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?value='+ NEV + '&co=' + countr +'',
                success: function (data) {

                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    $("#finalDiv").append( 'Day: '+responsedata.day2+ '<br>' +'Month: ' +responsedata.month)   ;
                }
            });
        }
        if ( mode === 'c') {
            $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?sktesttest=1',
                success: function (data) {

                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    var length2=responsedata.length;
                    for (i=parseInt(length2) ; i!==0; i--){
                        console.log(i);

                        $("#finalDiv").append( responsedata[i-1].testtest + '    &nbsp &nbsp &nbsp   day:  '+ responsedata[i-1].day2+ ' &nbsp &nbsp &nbsp  Month:  ' + responsedata[i-1].month+'<br>')   ;

                    }

                }
            });
        }

        if ( mode === 'd') {
            $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?cztesttest=1',
                success: function (data) {

                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    var length2=responsedata.length;
                    for (i=parseInt(length2) ; i!==0; i--){
                        console.log(i);
                        $("#finalDiv").append( responsedata[i-1].testtest + '    &nbsp &nbsp &nbsp   day:  '+ responsedata[i-1].day2+ ' &nbsp &nbsp &nbsp  Month:  ' + responsedata[i-1].month+'<br>')   ;

                    }

                }
            });

        }
        if ( mode === 'e') {
            $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?skday2=1',
                success: function (data) {

                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    var length2=responsedata.length;
                    for (i=parseInt(length2) ; i!==0; i--){
                        console.log(i);

                        $("#finalDiv").append( responsedata[i-1].testtest + '    &nbsp &nbsp &nbsp   day:  '+ responsedata[i-1].day2+ ' &nbsp &nbsp &nbsp  Month:  ' + responsedata[i-1].month+'<br>')   ;
                    }
                }
            });
        }

        if ( mode === 'f') {
            var NEV= document.getElementById('nevadd').value
            var d2= $("#datum2").val();
            var afterDot2 = d2.substr(d2.indexOf('-')+1);
            var day22= afterDot2.slice(-2)
            var month2 = afterDot2.slice(0,2)

            if (afterDot2[0] === '0'){
                afterDot2 = d2.substr(d2.indexOf('-')+2);
                month2 = afterDot2.slice(0,1)
            }

            $.ajax({
                type: 'POST',
                url: 'http://147.175.98.50/zadanie_6/index.php?&value='+ NEV + '&day2=' + day22 + '&month=' + month2 +'',

                success: function (data) {
                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    $("#finalDiv").append( "Ulozene")   ;
                }
            });

        }

    });

});