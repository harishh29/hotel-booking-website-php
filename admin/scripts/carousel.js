
        
        

        let carousel_setting_form = document.getElementById('carousel_setting_form');

        
        let carousel_pic_input = document.getElementById('carousel_pic_input');


        

        carousel_setting_form.addEventListener('submit', function(e){
            e.preventDefault();
            add_image();
        })

        function add_image(){
            
            let data = new FormData();
            
            data.append('picture', carousel_pic_input.files[0]);
            data.append('add_image', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/carousel_crud.php", true);
            

            xhr.onload = function(){
                console.log(this.responseText);
                var myModal = document.getElementById('carousel-setting');
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
                    alert('success', 'New Images Added')
                    carousel_pic_input.value = '';
                    get_carousel();
                }



            }
            xhr.send(data);
        }

        function get_carousel(){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/carousel_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('carousel-data').innerHTML = this.responseText;
            }
            xhr.send('get_carousel');
        }

        function rem_image(val){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/carousel_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'Image Removed Succesfully');
                }
                else{
                    alert('error', 'Server Down');
                }
            }
            xhr.send('rem_image='+val);
        }



        window.onload = function(){
            
            get_carousel();
        }
