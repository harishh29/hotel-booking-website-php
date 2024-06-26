<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - FACILITIES</title>
    <style>
      .pop:hover{
        border-top-color: var(--sage-hover) !important;
        transform: scale(1.03);
        transition: all 0.3s;
        
      }
      
    </style>
</head>
<body class="bg-light">
  <!-- Header -->
  <?php require('inc/header.php')?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
      Our dedicated and experienced staff caters to the needs of our
       business and leisure guest with an extensive range of services <br> 
       and facilities available to ensure your comfort and convenience 
       throughout their stay at Kafka Hotel.
    </p>
  </div>

  <div class="container">
    <div class="row">

      <?php 
        $res = selectAll('facilities');
        $path = FEATURES_IMAGE_PATH;

        while($row = mysqli_fetch_assoc($res)){
          echo<<< data
          <div class="col-lg-4 col-md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop" >
              <div class="d-flex align-items-center mb-2">
              <img src="$path$row[icon]" width="40px" alt="">
              <h5 class="m-0 ms-3">$row[name]</h5>
              </div>
              <p>
                $row[description]
              </p>
            </div>
          </div>
          data;
        }
      
      ?>
      
    </div>
  </div>

  
  <!-- footer -->

  <?php require('inc/footer.php')?>

  
</body>
</html>