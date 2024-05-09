

function get_user(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/user.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function(){
       document.getElementById('user-data').innerHTML = this.responseText;
    }
    xhr.send('get_user');
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

function search_user(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/user.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function(){
       document.getElementById('user-data').innerHTML = this.responseText;
    }
    xhr.send('search_user&name='+username);
}

window.onload = function(){
    get_user();
}