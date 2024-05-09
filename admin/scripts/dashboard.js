

function booking_analytics(period){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('total_booking').textContent = data.total_booking;
        document.getElementById('total_amt').textContent = 'RM ' + data.total_amt;

        document.getElementById('active_booking').textContent = data.active_booking;
        document.getElementById('active_amt').textContent = 'RM ' + data.active_amt;

        document.getElementById('refunded_booking').textContent = data.refunded_booking;
        document.getElementById('refunded_amt').textContent = 'RM ' + data.refunded_amt;
    }
    xhr.send('booking_analytics&period='+period);
}

function user_analytics(period){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('total_new_reg').textContent = data.total_new_reg;
        

        document.getElementById('total_queries').textContent = data.total_queries;
        

        document.getElementById('total_review').textContent = data.total_review;
       
    }
    xhr.send('user_analytics&period='+period);
}









window.onload = function(){
    booking_analytics();
    user_analytics();
}