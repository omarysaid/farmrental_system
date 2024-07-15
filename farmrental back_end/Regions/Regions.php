<?php

$regionsAndDistricts = array(
    "Arusha" => array("Arusha", "Meru", "Karatu", "Longido", "Ngorongoro"),
    "Dar es Salaam" => array("Ilala", "Kinondoni", "Temeke", "Kigamboni"),
    "Dodoma" => array("Dodoma", "Bahi", "Chamwino", "Kondoa", "Kongwa"),
    "Geita" => array("Geita", "Bukombe", "Mbogwe", "Chato", "Nyang'hwale"),
    "Iringa" => array("Iringa", "Mufindi", "Kilolo", "Iringa District"),
    "Kagera" => array("Bukoba", "Muleba", "Karagwe", "Ngara", "Biharamulo"),
    "Katavi" => array("Mpanda", "Mlele", "Nsimbo", "Tanganyika"),
    "Kigoma" => array("Kigoma", "Kakonko", "Kasulu", "Kibondo", "Buhigwe"),
    "Kilimanjaro" => array("Moshi", "Hai", "Rombo", "Same", "Mwanga", "Siha"),
    "Lindi" => array("Lindi", "Kilwa", "Liwale", "Nachingwea", "Ruangwa"),
    "Manyara" => array("Babati", "Hanang", "Mbulu", "Simanjiro", "Kiteto"),
    "Mara" => array("Musoma", "Bunda", "Butiama", "Rorya", "Serengeti"),
    "Mbeya" => array("Mbeya", "Chunya", "Kyela", "Rungwe", "Mbarali"),
    "Morogoro" => array("Morogoro", "Gairo", "Kilombero", "Ulanga", "Malinyi"),
    "Mtwara" => array("Mtwara", "Masasi", "Nanyumbu", "Tandahimba", "Newala"),
    "Mwanza" => array("Mwanza", "Ilemela", "Kwimba", "Sengerema", "Magu", "Ukerewe", "Bukoba Rural"),
    "Njombe" => array("Njombe", "Ludewa", "Makambako", "Wanging'ombe", "Makete", "Njombe"),
    "Pwani" => array("Kibaha", "Bagamoyo", "Kisarawe", "Mafia", "Rufiji", "Kibiti"),
    "Rukwa" => array("Sumbawanga", "Kalambo", "Nkasi", "Sumbawanga District"),
    "Ruvuma" => array("Songea", "Mbinga", "Tunduru", "Nyasa", "Mbozi"),
    "Shinyanga" => array("Shinyanga", "Kahama", "Kishapu", "Shinyanga District", "Msalala"),
    "Simiyu" => array("Bariadi", "Meatu", "Maswa", "Itilima", "Busega"),
    "Singida" => array("Singida", "Manyoni", "Ikungi", "Singida District"),
    "Tabora" => array("Tabora", "Uyui", "Kaliua", "Sikonge", "Nzega", "Tabora"),
    "Tanga" => array("Tanga", "Korogwe", "Handeni", "Kilindi", "Lushoto", "Muheza"),
);


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'get_regions') {
        $regions = array_keys($regionsAndDistricts);
        echo json_encode($regions);
    } elseif ($action === 'get_districts') {
        if (isset($_GET['region'])) {
            $region = $_GET['region'];
            if (array_key_exists($region, $regionsAndDistricts)) {
                
                echo json_encode($regionsAndDistricts[$region]);
            } else {
              
                echo json_encode(array("error" => "Region not found"));
            }
        } else {
          
            echo json_encode(array("error" => "Region parameter is missing"));
        }
    } else {
       
        echo json_encode(array("error" => "Invalid action"));
    }
} else {
   
    echo json_encode(array("error" => "Action parameter is missing"));
}

?>