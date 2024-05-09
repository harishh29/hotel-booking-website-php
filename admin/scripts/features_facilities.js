
    let ft_setting_form = document.getElementById('ft_setting_form');
    let fc_setting_form = document.getElementById('fc_setting_form');

    // feature function
    ft_setting_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_feature();
    })

    function add_feature(){
        
        let data = new FormData();
        data.append('name' , ft_setting_form.elements['feature_name'].value);
        data.append('add_feature', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/features_facilities.php", true);
        

        xhr.onload = function(){
            console.log(this.responseText);
            var myModal = document.getElementById('ft-setting');
            var modal = bootstrap.Modal.getInstance(myModal); 
            modal.hide();

            if(this.responseText == 1){
                alert('success', 'New features added!');
                ft_setting_form.elements['feature_name'].value='';
                get_feature();
            }
            
            else{
                alert('error', 'Failed to add features!')
            }



        }
        xhr.send(data);
    }

    function get_feature(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('feature-data').innerHTML = this.responseText;
        }
        xhr.send('get_feature');
    }

    function rem_feature(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.responseText == 1){
                alert('success', 'Feature Removed Succesfully');
                get_feature();
            }
            else if(this.responseText == 'room_added'){
                alert('error', 'Feature is added in room!');
            }
            else{
                alert('error', 'Server Down');
            }
        }
        xhr.send('rem_feature='+val);
    }

    // facility section
    fc_setting_form.addEventListener('submit', function(e){
        e.preventDefault();
        add_facility();
    })

    function add_facility(){
        
        let data = new FormData();
        data.append('name' , fc_setting_form.elements['facility_name'].value);
        data.append('icon' , fc_setting_form.elements['facility_icon'].files[0]);
        data.append('description' , fc_setting_form.elements['facility_desc'].value);
        data.append('add_facility', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/features_facilities.php", true);
        

        xhr.onload = function(){
            console.log(this.responseText);
            var myModal = document.getElementById('fc-setting');
            var modal = bootstrap.Modal.getInstance(myModal); 
            modal.hide();

            if(this.responseText == 'invalid_img'){
                alert('error', 'Only SVG images are allowed');
            }
            else if(this.responseText == 'invalid_size'){
                alert('error', 'Image should be less than 2MB');
            }
            else if(this.responseText == 'upd_failed'){
                alert('error', 'Image upload failed');
            }
            else{
                alert('success', 'New Facility Added')
                fc_setting_form.reset();
                
                get_facility();
            }
        }
        xhr.send(data);
    }

    function get_facility(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('facility-data').innerHTML = this.responseText;
        }
        xhr.send('get_facility');
    }

    function rem_facility(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/features_facilities.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.responseText == 1){
                alert('success', 'Facility Removed Succesfully');
                get_facility();
            }
            else if(this.responseText == 'room_added'){
                alert('error', 'Facility is added in room!');
            }
            else{
                alert('error', 'Server Down');
            }
        }
        xhr.send('rem_facility='+val);
    }

    window.onload =function(){
        get_feature();
        get_facility()
    }


 