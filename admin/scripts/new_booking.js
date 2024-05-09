

function get_booking(search=''){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_booking.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    

    xhr.onload = function(){
       document.getElementById('table-data').innerHTML = this.responseText;
    }
    xhr.send('get_booking&search='+search);
}

let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id){
 assign_room_form.elements['booking_id'].value = id;
}

assign_room_form.addEventListener('submit', function(e){
    e.preventDefault();

    let data = new FormData();
    data.append('room_no' , assign_room_form.elements['room_no'].value);
    data.append('booking_id' , assign_room_form.elements['booking_id'].value);
    data.append('assign_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_booking.php", true);
    

    xhr.onload = function(){
        console.log(this.responseText);
        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal); 
        modal.hide();

        if(this.responseText == 1){
            alert('success', 'Room Number Assigned!');
            assign_room_form.reset();

            get_booking();
        }
       
        else{
            alert('error', 'Server Down')
          
        }
    }
    xhr.send(data);
    
})

function cancel_booking(id){
    if(confirm("Please confirm if you want to cancel this booking!")){

        let data = new FormData();
        
        
        data.append('booking_id', id);
        data.append('cancel_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_booking.php", true);
        
        xhr.onload = function(){
            
            if(this.responseText == 1){
                alert('success', 'Booking Cancelled!')
                get_booking();
            }
            else{
                alert('error', 'Server Down!');
            }

        }
        xhr.send(data);
    }

}

function toggle_status(id,val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/user.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    

    xhr.onload = function(){
      if(this.responseText==1){
        alert('success','Status Toggled');
        get_user();
      }
      else{
        alert('error','Server Down');
      }
    }
    xhr.send('toggle_status='+id+'&value='+val);

}

function remove_user(user_id){

    if(confirm("Please confirm if you want to delete this user!")){

        let data = new FormData();
        
        data.append('user_id', user_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/user.php", true);

        xhr.onload = function(){

            if(this.responseText == 1){
                alert('success', 'User Removed!')
                get_user();
            }
            else{
                alert('error', 'Failed to remove user!');
            }

        }
        xhr.send(data);
    }
}

// function search_booking(id){
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "ajax/new_booking.php", true);
//     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    

//     xhr.onload = function(){
//        document.getElementById('table-data').innerHTML = this.responseText;
//     }
//     xhr.send('search_booking&name='+username);
// }

window.onload = function(){
    get_booking();
}