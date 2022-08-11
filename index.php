<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Explorer</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Aditya</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        
        <a class="nav-link" href="#">Tools</a>
        <a class="nav-link" href="#">About</a>
        <a class="nav-link" href="#">Contact</a>
        <a class="nav-link "></a>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Donate</button>
  </div>
</nav>
<div class="container" style="margin-top: 40px">
    <div >
        <form method="post" class="mb-3">
            <div class="input-group mb-3" style="margin: 10px; justify-items-center	">
                 <input type="text" name="query"class="form-control" style="width: auto;" <?php 
                 
                 if(isset($_POST['query'])){ 
                    $query = $_POST['query'] ;
                echo "value=\"$query\"" ; } ?>
                placeholder="Enter Broad Intrest To explroe" aria-label="Recipient's username" aria-describedby="basic-addon2">
                 <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass" style="margin-right: 5px;"></i>Find</button>
                 <!-- <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass" style="margin-right: 5px;"></i>Find</span> -->
            </div>
        </form>   
    </div>
</div>
<?php 
if(!empty($_POST['query'])){

  error_reporting(E_ERROR | E_PARSE);
  
    $token="facebok_token";
    $query = $_POST['query'] ;
    $url= "https://graph.facebook.com/search?type=adinterest&q=[$query]&limit=10000&locale=en_US&access_token=$token" ;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $result=curl_exec($ch);
    curl_close($ch);
    $data = json_decode($result,true);
   // print_r($data);
    
  
    echo "
<div class=\"container flex justify-center mx-auto\">
    <div class=\"flex flex-col\">
        <div class=\"w-full\">
            <div class=\"border-b border-gray-200 shadow rounded-lg\">
                <table class=\"divide-y divide-gray-300 \">
                    <thead style=\"background-color: #0d6efd;\">
                        <tr>
                            <th class=\"px-6 py-2 text-xs text-white\">
                                Interest
                            </th>
                            <th class=\"px-6 py-2 text-xs text-white\">
                                Minimum Audience
                            </th>
                            <th class=\"px-6 py-2 text-xs text-white\">
                                Maximum Audience
                            </th>
                            <th class=\"px-6 py-2 text-xs text-white\">
                                Category
                            </th>
                           
                        </tr>
                    </thead>"; ?>
                    <?php 
                    foreach($data['data'] as $list) {
                        $intrest= $list['name'];
                        $mini= $list['audience_size_lower_bound'] ;
                        $max= $list['audience_size_upper_bound'];
                        if(isset($list['topic'])){
                        $topic = $list['topic'];
                        }
                        else{
                        $topic= "Unknown" ;  
                        }
                   echo  "<tbody class=\"bg-white divide-y divide-gray-300\">
                        <tr class=\"whitespace-nowrap\">
                            <td class=\"px-6 py-4 text-sm text-gray-900\">
                            $intrest
                            </td>
                            <td class=\"px-6 py-4\">
                                <div class=\"text-sm text-gray-900\">
                                $mini   
                                </div>
                            </td>
                            <td class=\"px-6 py-4\">
                                <div class=\"text-sm text-gray-900\">$max</div>
                            </td>
                            <td class=\"px-6 py-4 text-sm text-gray-900\">
                                $topic
                            </td>
                            
                        </tr>
                        
                    </tbody>";
                    }
                   echo" 
                </table>
            </div>
        </div>
    </div>
</div>";

  }
?>
<?php
if(empty($_POST['query'])){
echo "<div style=\"padding: 85px\">
    <h1><strong>
    Facebook interest targeting tool reveals <strong class=\"text-teal-500\"><u>1000's of hidden Facebook interests</u></strong> you can target without your competition knowing
    </strong>    
</h1>
</div>" ;
}
?>
</body>
</html>
