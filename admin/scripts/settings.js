
        let general_data, contact_data;

        let g_setting_form = document.getElementById('g_setting_form');
        
        let site_title_input = document.getElementById('site_title_input');
        let site_about_input = document.getElementById('site_about_input');

        let c_setting_form = document.getElementById('c_setting_form');

        let m_setting_form = document.getElementById('m_setting_form');

        let member_name_input = document.getElementById('member_name_input');
        let member_pic_input = document.getElementById('member_pic_input');

        function get_general(){
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');

            let shutdown_toggle = document.getElementById('shutdown_toggle');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                general_data = JSON.parse(this.responseText);

                site_title.innerText = general_data.site_title;
                site_about.innerText = general_data.site_about;

                site_title_input.value = general_data.site_title;
                site_about_input.value = general_data.site_about;

                if(general_data.shutdown == 0){
                    shutdown_toggle.checked = false;
                    shutdown_toggle.value = 0;
                }else{
                    shutdown_toggle.checked = true;
                    shutdown_toggle.value = 1;
                }
                
            }
            xhr.send('get_general');
        }

        g_setting_form.addEventListener('submit',function(e){
            e.preventDefault();
            upd_general(site_title_input.value, site_about_input.value);
        })

        function upd_general(site_title_value, site_about_value){
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');

            let site_title_input = document.getElementById('site_title_input');
            let site_about_input = document.getElementById('site_about_input');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                var myModal = document.getElementById('g-setting');
                var modal = bootstrap.Modal.getInstance(myModal); // Returns a Bootstrap modal instance
                modal.hide();

                if(this.responseText == 1){
                    alert('success','Changes Saved');
                    get_general();
                }else{
                    alert('error', "No changes made!");
                }
                
            }
            xhr.send('site_title='+ site_title_value+'&site_about='+site_about_value+'&upd_general');
        }

        function upd_shutdown(val){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                

                if(this.responseText == 1  && general_data.shutdown == 0){
                    alert('success','Website is offline!');
                    
                }else{
                    alert('success', "Website in online!");
                }
                get_general();
            }
            xhr.send('upd_shutdown='+val);
        }

        function get_contact(){
            
            let contact_p_id = ['address', 'gmap', 'phn1', 'phn2', 'email', 'tw', 'ig', 'fb'];
            let iframe = document.getElementById('iframe');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                contact_data = JSON.parse(this.responseText);
                contact_data = Object.values(contact_data);     
                 

                for(i=0;i<contact_p_id.length;i++){
                    document.getElementById(contact_p_id[i]).innerText = contact_data[i+1];
                }
                iframe.src = contact_data[9];
                contact_input(contact_data);
            }
            xhr.send('get_contact');
        }

        function contact_input(data){

            let contact_input_id = ['address_input', 'gmap_input', 'phn1_input', 'phn2_input', 'email_input', 'tw_input', 'ig_input', 'fb_input', 'iframe_input'];

            for(i=0;i<contact_input_id.length;i++){
                document.getElementById(contact_input_id[i]).value = data[i+1];
            }
        }

        c_setting_form.addEventListener('submit', function(e){
            e.preventDefault();
            upd_contact();
        })

        function upd_contact(){
            let index = ['address', 'gmap', 'phn1', 'phn2', 'email', 'tw', 'ig', 'fb', 'iframe'];
            let contact_input_id = ['address_input', 'gmap_input', 'phn1_input', 'phn2_input', 'email_input', 'tw_input', 'ig_input', 'fb_input', 'iframe_input'];
            let data_str ="";

            for(i=0;i<index.length;i++){
               data_str += index[i]+ "=" + document.getElementById(contact_input_id[i]).value + "&";
            }
            data_str += "upd_contact";

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                var myModal = document.getElementById('c-setting');
                var modal = bootstrap.Modal.getInstance(myModal); // Returns a Bootstrap modal instance
                modal.hide()

                if(this.responseText == 1){
                    alert('success','Changes Saved');
                    get_contact();
                }else{
                    alert('error', "No changes made!");
                }
            }

            xhr.send(data_str);
        }

        m_setting_form.addEventListener('submit', function(e){
            e.preventDefault();
            add_member();
        })

        function add_member(){
            
            let data = new FormData();
            data.append('name' , member_name_input.value);
            data.append('picture', member_pic_input.files[0]);
            data.append('add_member', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            

            xhr.onload = function(){
                console.log(this.responseText);
                var myModal = document.getElementById('m-setting');
                var modal = bootstrap.Modal.getInstance(myModal); 
                modal.hide();

                if(this.responseText == 'invalid_img'){
                    alert('error', 'Only Jpg and Png images are allowed');
                }
                else if(this.responseText == 'invalid_size'){
                    alert('error', 'Image should be less than 2MB');
                }
                else if(this.responseText == 'upd_failed'){
                    alert('error', 'Image upload failed');
                }
                else{
                    alert('success', 'New member Added')

                    member_name_input.value = '';
                    member_pic_input.value = '';
                    get_member();
                }



            }
            xhr.send(data);
        }

        function get_member(){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('team_data').innerHTML = this.responseText;
            }
            xhr.send('get_member');
        }

        function rem_member(val){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'Member Removed Succesfully');
                }
                else{
                    alert('error', 'Server Down');
                }
            }
            xhr.send('rem_member='+val);
        }



        window.onload = function(){
            get_general();
            get_contact();
            get_member();
        }
