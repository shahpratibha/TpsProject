    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    // Connect to database
    $db = mysqli_connect('localhost', 'root', '', 'jfsa');

    // Retrieve user details from database
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);


    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TCPL</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css">


        <!-- BOOTSTRAP only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <!-- jquery -->
        <script src="libs/jquery.js"></script>
        <link rel="stylesheet" href="libs/jquery-ui-1.12.1/jquery-ui.css">
        <script src="libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
        <script src="libs/jquery-ui-1.12.1/jquery-ui.js"></script>

        <!-- Leaflet -->

        <link rel="stylesheet" href="libs/leaflet/leaflet.css" />
        <script src="libs/leaflet/leaflet.js"></script>

        <!-- ZoomBar & slider-->
        <script src="libs/L.Control.ZoomBar-master/src/L.Control.ZoomBar.js"></script>
        <link rel="stylesheet" href="libs/L.Control.ZoomBar-master/src/L.Control.ZoomBar.css" />
        <script src="libs/Leaflet.zoomslider-master/src/L.Control.Zoomslider.js"></script>
        <link rel="stylesheet" href="libs/Leaflet.zoomslider-master/src/L.Control.Zoomslider.css" />

        <!-- MousePosition -->
        <script src="libs/Leaflet.MousePosition-master/src/L.Control.MousePosition.js"></script>
        <link rel="stylesheet" href="libs/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" />

        <!-- line-measure -->
        <link rel="stylesheet" href="libs/polyline-measure/line-measure.css" />
        <script src="libs/polyline-measure/line-measure.js"></script>
        <link rel="stylesheet" href="libs/leaflet-measure-master/leaflet-measure.css" />
        <script src="libs/leaflet-measure-master/leaflet-measure.js"></script>
        <script src="libs/feat.js"></script>


        <!-- draw -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css" />
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script> -->

        <!-- 
    <link rel="stylesheet" href="libs/leaflet-draw-control.css"> -->
        <script src="libs/leaflet-draw-control.js"></script>


        <!-- github -->
        <script src="https://kartena.github.io/Proj4Leaflet/lib/proj4-compressed.js"></script>
        <script src="https://kartena.github.io/Proj4Leaflet/src/proj4leaflet.js"></script>



        <!-- legend -->

        <link rel="stylesheet" href="libs/leaflet-wms-legend/leaflet.wmslegend.css" />
        <script src="libs/leaflet-wms-legend/leaflet.wmslegend.js"></script>


        <!-- csslink -->
        <link rel="stylesheet" href="mystyle.css">



        <!-- html2pdfcdn -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script> -->

        <script src="libs/leaflet-image.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

        <!-- fontawsome -->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

        <!-- json -->

        <script>
            $(function() {
                var availableTags = ['Pimpalgaon Tarf Khed,Khed', 'Rohakal,Khed', 'Kanersar,Khed', 'Chinchoshi,Khed',
                    'Sabalewadi,Khed', 'Sidhegavhan,Khed', 'Torne Bk,Khed', 'Hedruj,Khed', 'Davadi,Khed',
                    'Nimgaon,Khed', 'Kadus,Khed', 'Talawade,Khed', 'Kohinde Bk.,Khed', 'Bahirwadi,Khed',
                    'Pangari,Khed', 'Pait,Khed', 'Shelu,Khed', 'Koregaon Kh,Khed', 'Koregaon bk,Khed',
                    'Chandus,Khed', 'Retavadi,Khed', 'Kharpudi Bk,Khed', 'Pimpari Bk,Khed', 'Kharpudi Kh,Khed',
                    'Kalewadi,Khed', 'Padali,Khed', 'Koye,Khed', 'Gosasi,Khed', 'Vadgaon Ghenand,Khed',
                    'Manjarewadi,Khed', 'Kurkundi,Khed', 'Raundhalwadi,Khed', 'Kalus,Khed', 'Shive,Khed',
                    'Gargotiwadi,Khed', 'Kiwale,Khed', 'Jaidwadi,Khed', 'Khalchi Bhamburwadi,Khed',
                    'Arudewadi,Khed', 'Kohinkarwadi,Khed', 'Gulani,Khed', 'Pur,Khed', 'Jaulke Kh.,Khed',
                    'Waki BK,Khed', 'Ahire,Khed', 'Dhamane,Khed', 'Askhed Bk,Khed', 'Kaman,Khed', 'Chas,Khed',
                    'Papalwadi,Khed', 'Mirajewadi,Khed', 'Wakalwadi,Khed', 'Takalkarwadi,Khed', 'Donde,Khed',
                    'Wahagaon,Khed', 'Karanj Vihire,Khed', 'Koyali Tarf Chakan,Khed', 'Akharwadi,Khed',
                    'Jaulke Bk.,Khed', 'Vaphgaon,Khed', 'Chichbaiwadi,Khed', 'Gadakwadi,Khed', 'Chaudharwadi,Khed',
                    'Warude,Khed', 'Butewadi,Khed', 'Waki Tarf Wada,Khed', 'Gonvadi,Khed', 'Pimpari Kh.,Khed',
                    'Bahul,Khed', 'Chakan,Khed', 'Rajgurunagar,Khed', 'Shelgaon,Khed', 'Askhed Kh,Khed',
                    'Parale,Khed', 'Malkhed,Haveli', 'Bakori,Haveli', 'Gogalwadi,Haveli', 'Kondhanpur,Haveli',
                    'Mandavi Kh,Haveli', 'Mandavi Bk.,Haveli', 'Khadakwadi,Haveli', 'Aambi,Haveli',
                    'Alandi Mhatobachi,Haveli', 'Walati,Haveli', 'Manerwadi,Haveli', 'Tikekarwadi,Haveli',
                    'Khanapur,Haveli', 'Sashte,Haveli', 'Tarade,Haveli', 'Dongargaon,Haveli', 'Thoptewadi,Haveli',
                    'Gorhe Kh.,Haveli', 'Dehu,Haveli', 'Malinagar,Haveli', 'Vitthal Nagar,Haveli',
                    'Gorhe Bk.,Haveli', 'Bivari,Haveli', 'Sangarun,Haveli', 'Agalambe,Haveli', 'Arvi,Haveli',
                    'Pimpri Tarf Sandas,Haveli', 'Sangavi Tarf Sandas,Haveli', 'Jambhali,Haveli', 'Ashtapur,Haveli',
                    'Bhagatwadi,Haveli', 'Gaud Dara,Haveli', 'Wade Bolhai,Haveli', 'Shindwane,Haveli',
                    'Kalyan,Haveli', 'Ghera Sinhgad,Haveli', 'Kudaje,Haveli', 'Donaje,Haveli', 'Wanjalewadi,Haveli',
                    'Burkegaon,Haveli', 'Nhavi Sandas,Haveli', 'Shindewadi,Haveli', 'Gawadewadi,Haveli',
                    'Murkutenagar,Haveli', 'Khamgaon Tek,Haveli', 'Ramoshiwadi,Haveli', 'Mokarwadi,Haveli',
                    'Khadewadi,Haveli', 'Bahuli,Haveli', 'Tanaji Nagar,Haveli', 'Sonapur,Haveli', 'Vardare,Haveli',
                    'Sambharewadi,Haveli', 'Khamgaon Mawal,Haveli', 'Mogarwadi,Haveli', 'Mordarwadi,Haveli',
                    'Avasare,Haveli', 'Rahatvade,Haveli', 'Hingangaon,Haveli', 'Shiraswadi,Haveli', 'Katavi,Mawal',
                    'Kale,Mawal', 'Prabhachiwadi,Mawal', 'Yelse,Mawal', 'Ardav (Adavi),Mawal', 'Kadadhe,Mawal',
                    'Nane,Mawal', 'Tung,Mawal', 'Tikona,Mawal', 'Chavsar,Mawal', 'Boravli,Mawal', 'Inglun,Mawal',
                    'Khand,Mawal', 'Kolechafesar,Mawal', 'Kusur,Mawal', 'Morave,Mawal', 'Pimpriwadi,Mawal',
                    'Shivali,Mawal', 'Thoran,Mawal', 'Ukasan,Mawal', 'Vadeshwar,Mawal', 'Kusgaon P.m.,Mawal',
                    'Takave Bk.,Mawal', 'Shevati,Mawal', 'Pansoli,Mawal', 'Atvan,Mawal', 'Malegao Bk.,Mawal',
                    'Apati,Mawal', 'Bhajgaon,Mawal', 'Bhoyre,Mawal', 'Divad,Mawal', 'Govitri,Mawal', 'Jovan,Mawal',
                    'Kondiwade,Mawal', 'Pachane,Mawal', 'Pale,Mawal', 'Udhewadi,Mawal', 'Vadavali,Mawal',
                    'Pangloli,Mawal', 'Karandoli,Mawal', 'Dhaiwali,Mawal', 'Shilatane,Mawal', 'Takave Kh.,Mawal',
                    'Rajpuri,Mawal', 'Kurvande,Mawal', 'Lonawale,Mawal', 'Malavandi Thule,Mawal', 'Ambegaon,Mawal',
                    'Kunewadi,Mawal', 'Dahuli,Mawal', 'Mangarul,Mawal', 'Somwadi,Mawal', 'Kondivade N.m,Mawal',
                    'Dudhivare,Mawal', 'Vagheshwar,Mawal', 'Shilimb,Mawal', 'Sawale,Mawal', 'Pusane,Mawal',
                    'Malegao Kh,Mawal', 'Ajivali,Mawal', 'Valakh,Mawal', 'Sawantwadi,Mawal', 'Malewadi,Mawal',
                    'Mahagaon,Mawal', 'Lohagad,Mawal', 'Kambare N.m.,Mawal', 'Dhalewadi,Mawal', 'Budhavadi,Mawal',
                    'Gevhandhe,Mawal', 'Nagatali,Mawal', 'Rakaswadi,Mawal', 'Kusavali,Mawal', 'Wahangao,Mawal',
                    'Kiwale,Mawal', 'Shirdhe,Mawal', 'Jamboli,Mawal', 'Nandgaon,Mawal', 'Shindgaon,Mawal',
                    'Kambare Andar,Mawal', 'Kashal,Mawal', 'Khandashi,Mawal', 'Nesave,Mawal', 'Valavanti,Mawal',
                    'Dhangavhan,Mawal', 'Ovale,Mawal', 'Yelghol,Mawal', 'Velholi,Mawal', 'Karanjgaon,Mawal',
                    'Sangise,Mawal', 'Pale Nane Mawal,Mawal', 'Mormarwadi,Mawal', 'Mau,Mawal', 'Kacharewadi,Mawal',
                    'Vaund,Mawal', 'Brahmanwadi,Mawal', 'Done,Mawal', 'Kothurne,Mawal', 'Shire,Mawal',
                    'Belaj,Mawal', 'Jeware,Mawal', 'Vehergaon,Mawal', 'Budhle N.M.,Mawal', 'Vadivale,Mawal',
                    'Adhale bk,Mawal', 'Adhale kh.,Mawal', 'Shivane,Mawal', 'Phalne,Mawal', 'Ghonshet,Mawal',
                    'Sai,Mawal', 'Bhadawali,Mawal', 'Majgaon,Mawal', 'Pimpal Khunte,Mawal', 'Malawali P.m.,Mawal',
                    'Bedse,Mawal', 'Thugaon,Mawal', 'Varu,Mawal', 'Phagane,Mawal', 'Kadav,Mawal',
                    'Gevhande Khadak,Mawal', 'Keware,Mawal', 'Thakursai,Mawal', 'Brahmanoli,Mawal', 'Muthe,Mulshi',
                    'Padalgharwadi,Mulshi', 'Mugaon,Mulshi', 'Valane,Mulshi', 'Ugavali,Mulshi', 'Jawal,Mulshi',
                    'Ghutake,Mulshi', 'Ekole,Mulshi', 'Tailbaila,Mulshi', 'Bhambarde,Mulshi', 'Botarwadi,Mulshi',
                    'Chandivali,Mulshi', 'Andgaon,Mulshi', 'Dhamanohol,Mulshi', 'Koloshi,Mulshi', 'Sakhari,Mulshi',
                    'Kharavade,Mulshi', 'Pimploli,Mulshi', 'Masgaon,Mulshi', 'Wadavali,Mulshi', 'Admal,Mulshi',
                    'Bhembhatmal,Mulshi', 'Palase,Mulshi', 'Patharshet,Mulshi', 'Saiv Kh,Mulshi', 'Bhode,Mulshi',
                    'Mulshi Kh,Mulshi', 'Tata Talav,Mulshi', 'Karmoli,Mulshi', 'Shedani,Mulshi', 'Kolwan,Mulshi',
                    'Sathesai,Mulshi', 'Mugavde,Mulshi', 'Katavadi,Mulshi', 'Davje,Mulshi', 'Malegaon,Mulshi',
                    'Wanjale,Mulshi', 'Watunde,Mulshi', 'Vede,Mulshi', 'Mandede,Mulshi', 'Jatede,Mulshi',
                    'Kashing,Mulshi', 'Amaralewadi,Mulshi', 'Barape_Bk,Mulshi', 'Bhalgudi,Mulshi', 'Saltar,Mulshi',
                    'Shirvali,Mulshi', 'Nive,Mulshi', 'Andhale,Mulshi', 'Ambarwet,Mulshi', 'Vandre,Mulshi',
                    'Vadgaon,Mulshi', 'Pimpri,Mulshi', 'Rihe,Mulshi', 'Katarkhadak,Mulshi', 'Nandgaon,Mulshi',
                    'Padalghar,Mulshi', 'Mose Kh.,Mulshi', 'Dhadavali,Mulshi', 'Gadhale,Mulshi', 'Chinchwad,Mulshi',
                    'Kule,Mulshi', 'Hulavalewadi,Mulshi', 'Tamhini Bk,Mulshi', 'Warak,Mulshi', 'Vegre,Mulshi',
                    'Kolavade,Mulshi', 'Kondhur,Mulshi', 'Pethshahapur,Mulshi', 'Devghar,Mulshi', 'Ambavane,Mulshi',
                    'Kolavali,Mulshi', 'Pomgaon,Mulshi', 'Male,Mulshi', 'Kumbheri,Mulshi', 'Jamgaon,Mulshi',
                    'Share,Mulshi', 'Disali,Mulshi', 'Shileshwar,Mulshi', 'Bhadas Bk.,Mulshi', 'Gavadewadi,Mulshi',
                    'Dongrgaon,Mulshi', 'Hotale,Mulshi', 'Nanegaon,Mulshi', 'Asade,Mulshi', 'Chikhali Bk.,Mulshi',
                    'Belwade,Mulshi', 'Tav,Mulshi', 'Chale,Mulshi', 'Darawali (Dakhli),Mulshi', 'Morewadi,Mulshi',
                    'Bharekarwadi,Mulshi', 'Kasarsai,Mulshi', 'Visakhar,Mulshi', 'Walen,Mulshi', 'Hadasi,Mulshi',
                    'Kalamshet,Mulshi', 'Vitthalwadi,Mulshi', 'Andeshe,Mulshi', 'Khubawali,Mulshi',
                    'Temghar,Mulshi', 'Lavarde,Mulshi', 'Khechre,Mulshi', 'Marnewadi,Mulshi', 'Bhuini,Mulshi',
                    'Savargaon,Mulshi', 'Akole,Mulshi', 'Kondhavale,Mulshi', 'Paud,Mulshi', 'Dakhane,Mulshi',
                    'Sambhave,Mulshi', 'Khamboli,Mulshi', 'Kemasewadi,Mulshi', 'Adgaon,Mulshi',
                    'Chikhalgaon,Mulshi', 'Ravade,Mulshi', 'Nandivali,Mulshi', 'Dasave,Mulshi', 'Bhambavade,Bhor',
                    'Bhongavli,Bhor', 'Dhangavadi,Bhor', 'Gunand,Bhor', 'Kenjal,Bhor', 'Khadki,Bhor', 'Kikavi,Bhor',
                    'Morwadi,Bhor', 'Nhavi,Bhor', 'Nidhan,Bhor', 'Nigade,Bhor', 'Pande,Bhor', 'Panjalwadi,Bhor',
                    'Rajapur,Bhor', 'Sangavi Kh,Bhor', 'Sarole,Bhor', 'Savardare,Bhor', 'Taprewadi,Bhor',
                    'Umbare,Bhor', 'Vathar Kh,Bhor', 'Wagajwadi,Bhor', 'Degaon,Bhor', 'Didghar,Bhor',
                    'Jambhali,Bhor', 'Kambare,Bhor', 'Kanjale,Bhor', 'Karandi,Bhor', 'Ketkavane,Bhor', 'Khopi,Bhor',
                    'Kolavadi,Bhor', 'Kurungvadi,Bhor', 'Kusgaon,Bhor', 'Malegaon,Bhor', 'Parvadi,Bhor',
                    'Ranje,Bhor', 'Salavade,Bhor', 'Sangavi Bk,Bhor', 'Sonavadi,Bhor', 'Virwadi,Bhor',
                    'Tamhanwadi,Daund', 'Sahajpurwadi,Daund', 'Nandur,Daund', 'Dalimb,Daund', 'Takali,Daund',
                    'Vadgaon Bande,Daund', 'Koregaon Bhiwar,Daund', 'Telewadi,Daund', 'Panwali,Daund',
                    'Pilanwadi,Daund', 'Mirwadi,Daund', 'Dahitane,Daund', 'Devkarwadi,Daund', 'Boribhadak,Daund',
                    'Boriaindi,Daund', 'Boratewadi,Daund', 'Bharatgaon,Daund', 'Jawajebuwachiwadi,Daund',
                    'Kamatwadi,Daund', 'Kasurdi,Daund', 'Bhandgaon,Daund', 'Patethan,Daund', 'Tambewadi,Daund',
                    'Ladkatwadi,Daund', 'Khutbav,Daund', 'Pimpalgaon,Daund', 'Delvadi (Ekeriwadi),Daund',
                    'Undawadi,Daund', 'Nathachiwadi,Daund', 'Valki,Daund', 'Rahu,Daund', 'Khamgaon,Daund',
                    'Nangaon,Daund', 'Amoni Mal,Daund', 'Ganesh Road,Daund', 'Varwand,Daund', 'Khopodi,Daund',
                    'Handalwadi,Daund', 'Wakhari,Daund', 'Dapodi,Daund', 'Pargaon,Daund', 'Deshmukh Mala,Daund',
                    'Nimbalkar Wasti,Daund', 'Galandwadi,Daund', 'Kodit Kh.,Purandar', 'Pur,Purandar',
                    'Pokhar,Purandar', 'Warwadi,Purandar', 'Kumbhoshi,Purandar', 'Somurdi,Purandar',
                    'Gherapurandhar,Purandar', 'Supe  Kh.,Purandar', 'Misalwadi,Purandar', 'Thapewadi,Purandar',
                    'Bhivari,Purandar', 'Bhivadi,Purandar', 'Bahirwadi,Purandar', 'Bhopgaon,Purandar',
                    'Patharwadi,Purandar', 'Pimpale,Purandar', 'Panvadi,Purandar', 'Hivare,Purandar',
                    'Kodit Budruk,Purandar', 'Askarwadi,Purandar', 'Chambali,Purandar', 'Borhalewadi,Purandar',
                    'Garade,Purandar', 'Ambawane,Velhe', 'Chinchale Bk,Velhe', 'Karajwane,Velhe', 'Adavali,Velhe',
                    'Askawadi,Velhe', 'Ketkavane,Velhe', 'Kolwadi,Velhe', 'Lasirgaon,Velhe', 'Margasani,Velhe',
                    'Khambawadi,Velhe', 'Mangdari,Velhe', 'Mangaon,Velhe', 'Pole,Velhe', 'Kasedi,Velhe',
                    'Chikhali Kh,Velhe', 'Bhalvadi,Velhe', 'Thangaon,Velhe', 'Shirkoli,Velhe', 'Ghodshet,Velhe',
                    'Ambed,Velhe', 'Khamgaon,Velhe', 'Vinzar,Velhe', 'Wangani,Velhe', 'Varasgaon,Velhe',
                    'Ambegaon Kh,Velhe', 'Gholapghar,Velhe', 'Kambegi,Velhe', 'Ranjane,Velhe', 'Dapode,Velhe',
                    'Chinchale Kh,Velhe', 'Kuran Bk,Velhe', 'Vadghar,Velhe', 'Givashi,Velhe', 'Koshimghar,Velhe',
                    'Mose Bk,Velhe', 'Saiv Bk.,Velhe', 'Ranavdi,Velhe', 'Boravale,Velhe', 'Nigade Bk.,Velhe',
                    'Panshet,Velhe', 'Kondgaon,Velhe', 'Malavli,Velhe', 'Kathawadi,Velhe', 'Rule,Velhe',
                    'Kuran Kh,Velhe', 'Dhindli,Velhe', 'Ambegaon Bk,Velhe', 'Osade,Velhe', 'Nigade Mose,Velhe',
                    'Kandave,Velhe', 'Wanjalwadi,Velhe', 'Kurvathi,Velhe', 'Pimpale Jagtap,Shirur',
                    'Wajewadi,Shirur', 'Kasari,Shirur', 'Jategaon Kh.,Shirur', 'Takali Bhima,Shirur',
                    'Kondhapuri,Shirur', 'Khairewadi,Shirur', 'Rautwadi,Shirur', 'Karandi,Shirur', 'Amdabad,Shirur',
                    'Jategaon Bk.,Shirur', 'Kendur,Shirur', 'Shastabad,Shirur', 'Khandale,Shirur',
                    'Sone Sangavi,Shirur', 'Hivare,Shirur', 'Burunjwadi,Shirur', 'Darekarwadi,Shirur',
                    'Vitthalwadi,Shirur', 'Dingrajwadi,Shirur', 'Malthan,Shirur', 'Waghale,Shirur', 'Varude,Shirur',
                    'Shivtakrar Mahalungi,Shirur', 'Shingadwadi,Shirur', 'Ranjangaon Sandas,Shirur',
                    'Rakshewadi,Shirur', 'Pimpale Dumal,Shirur', 'Pimpari Dumala,Shirur', 'Nimgaon Bhogi,Shirur',
                    'Mukhai,Shirur', 'Motewadi,Shirur', 'Midgulwadi,Shirur', 'Lakhewadi,Shirur',
                    'Karanjawane,Shirur', 'Golegaon,Shirur', 'Dhanore,Shirur', 'Dhamari,Shirur', 'Dahiwadi,Shirur',
                    'Chincholi,Shirur', 'Bhambarde,Shirur', 'Arangaon,Shirur', 'Ambale,Shirur',
                    'Ganegaon Burunjwadi,Shirur', 'Kanhur mesai,Shirur', 'Pabal,Shirur', 'Andhalgaon,Shirur',
                    'Nimone,Shirur', 'Nhavara,Shirur', 'Kohakdewadi,Shirur', 'Uralgaon,Shirur',
                    'Alegaon Paga,Shirur', 'Nagargaon,Shirur', 'Babhulsar Kh.,Shirur', 'Chavhanwadi,Shirur',
                    'Parodi,Shirur', 'Nimgaon Mhalungi,Shirur', 'Karade,Shirur', 'Nighoje,Khed', 'Moi,Khed',
                    'Khalumbre,Khed', 'Mahalunge,Khed', 'Kanhewadi Tarf Chakan,Khed', 'Sangurdi,Khed',
                    'Shinde,Khed', 'Wasuli,Khed', 'Yevalewadi,Khed', 'Sawardari,Khed', 'Kuruli,Khed',
                    'Medankarwadi,Khed', 'Nanekarwadi,Khed', 'Sudumbare,Mawal', 'Chimbali,Khed', 'Indori,Mawal',
                    'Biradwadi,Khed', 'Bhamboli,Khed', 'Ambethan,Khed', 'Kharabwadi,Khed', 'Warale,Khed',
                    'Kadachiwadi,Khed', 'Sudhavadi,Mawal', 'Jambavade,Mawal', 'Bhare,Mulshi', 'Kasar Amboli,Mulshi',
                    'Mukhaiwadi,Mulshi', 'Uravade,Mulshi', 'Bhukum,Mulshi', 'Nande,Mulshi', 'Sus,Mulshi',
                    'Bavadhan Bk,Mulshi', 'Vadki,Haveli', 'Ghotavde,Mulshi', 'Talegaon Dabhade (R),Mawal',
                    'Urse,Mawal', 'Parandwadi,Mawal', 'Bhilarewadi,Haveli', 'Jambhulwadi,Haveli', 'Kolavadi,Haveli',
                    'Sasewadi,Bhor', 'Shindewadi,Bhor', 'Lavale,Mulshi', 'Man,Mulshi', 'Sanas Nagar,Haveli',
                    'Nandoshi,Haveli', 'Pirangut,Mulshi', 'Vadgaon Shinde,Haveli', 'Loni-Kalbhor,Haveli',
                    'Dive,Purandar', 'Ambegaon,Mulshi', 'Pawarwadi,Purandar', 'Kalewadi,Purandar',
                    'Sonori,Purandar', 'Bhugaon,Mulshi', 'Manjari Kh.,Haveli', 'Manjari Bk,Haveli',
                    'Kolavdi,Haveli', 'Shevalwadi,Haveli', 'Kadamvak Wasti,Haveli', 'Holkarwadi,Haveli',
                    'Autad Handewadi,Haveli', 'Vadachiwadi,Haveli', 'Pisoli,Haveli', 'Bebad Ohol,Mawal',
                    'Dhamne,Mawal', 'Godumbare,Mawal', 'Shirgaon,Mawal', 'Gahunje,Mawal', 'Salumbe,Mawal',
                    'Sangavade,Mawal', 'Jambe,Mulshi', 'Nere,Mulshi', 'Dattawadi,Mulshi', 'Hinjavadi,Mulshi',
                    'Marunji,Mulshi', 'Mahalunge,Mulshi', 'Materewadi,Mulshi', 'Bhoirwadi,Mulshi',
                    'Bhegdewadi,Mulshi', 'Chande,Mulshi', 'Mulkhed,Mulshi', 'Godambewadi,Mulshi',
                    'Bhowarapur,Haveli', 'Uruli Kanchan,Haveli', 'Peth,Haveli', 'Koregaon Mul,Haveli',
                    'Prayagdham,Haveli', 'Sortapwadi,Haveli', 'Kunjirwadi,Haveli', 'Theur,Haveli', 'Naygaon,Haveli',
                    'Mangewadi,Haveli', 'Nimbalkarwadi,Haveli', 'Kirkitwadi,Haveli', 'Khadakwasale,Haveli',
                    'Nanded ,Haveli', 'Kopare,Haveli', 'Kondhave Dhavade,Haveli', 'Mendhewadi,Mawal',
                    'Varale,Mawal', 'Malawadi,Mawal', 'Ambi,Mawal', 'Brahman Wadi,Mawal', 'Sate,Mawal',
                    'Mohitewadi,Mawal', 'Chikhalse,Mawal', 'Ahirvade,Mawal', 'Kusgaon Kh.,Mawal',
                    'Khadkale (CT),Mawal', 'Kamshet,Mawal', 'Paravadi,Mawal', 'Sadavli,Mawal', 'Ozarde,Mawal',
                    'Baur,Mawal', 'Brahmanwadi,Mawal', 'Karunj,Mawal', 'Adhe Kh.,Mawal', 'Somatane,Mawal',
                    'Jadhavwadi,Mawal', 'Akurdi,Mawal', 'Nanoli Tarf Chakan,Mawal', 'Sangavi,Mawal',
                    'Umbare Navalakh,Mawal', 'Badhalawadi,Mawal', 'Naygaon,Mawal', 'Nanoli N.m.,Mawal',
                    'Jambhul,Mawal', 'Kanhe,Mawal', 'Ambale,Mawal', 'Nigade,Mawal', 'Kalhat,Mawal',
                    'Pawalewadi,Mawal', 'Boraj,Mawal', 'Patan,Mawal', 'Kusgaon Bk. (CT),Mawal', 'Devale,Mawal',
                    'Aundhe kh.,Mawal', 'Dongargaon,Mawal', 'Aundholi,Mawal', 'Varsoli,Mawal', 'Karla,Mawal',
                    'Waksai,Mawal', 'Devghar,Mawal', 'Sadapur,Mawal', 'Kune N.m.,Mawal', 'Bhaje,Mawal',
                    'Malvali,Mawal', 'Mudhavare,Mawal', 'Taje,Mawal', 'Pathargaon,Mawal', 'Pimploli,Mawal',
                    'Santosh Nagar ,Khed', 'Rakshewadi,Khed', 'Waki Kh,Khed', 'Holewadi,Khed', 'Chandoli,Khed',
                    'Varachi Bhamburwadi,Khed', 'Sandbhorwadi,Khed', 'Pacharnewadi,Khed', 'Dhorewadi,Khed',
                    'Vadgaon Tarf Khed,Khed', 'Shiroli,Khed', 'Satkarsthal,Khed', 'Koregaon Bhima _CT,Shirur',
                    'Sanaswadi ,Shirur', 'Shikrapur,Shirur', 'Talegaon Dhamdhere,Shirur', 'Apti,Shirur',
                    'Vadu Bk.,Shirur', 'Shirur_Annapur_Saradwadi_Tardobachiwadi_Kardilwad,Shirur',
                    'Dhok Sangavi,Shirur', 'Karegaon,Shirur', 'Ranjangaon Ganpati,Shirur', 'Vanpuri,Purandar',
                    'Udachiwadi,Purandar', 'Singapur,Purandar', 'Zendewadi,Purandar', 'Jadhavwadi,Purandar',
                    'Kumbharvalan,Purandar', 'Ambodi,Purandar', 'Gurholi,Purandar', 'Bhose,Khed', 'Alandi,Khed',
                    'Dhanore,Khed', 'Rase,Khed', 'Solu,Khed', 'Pimpalgaon Tarf Chakan,Khed', 'Tulapur,Haveli',
                    'Nirgudi,Haveli', 'Markal,Khed', 'Charholi Kh.,Khed', 'Kelgaon,Khed', 'Shivapur,Haveli',
                    'Khed Shivapur,Haveli', 'Ramnagar,Haveli', 'Kasurdi,Bhor', 'Shivare,Bhor', 'Velu,Bhor',
                    'Hrishchandri,Bhor', 'Kapurhol,Bhor', 'Divale,Bhor', 'Kamthadi,Bhor', 'Kelavade,Bhor',
                    'Nasrapur,Bhor', 'Naygaon,Bhor', 'Varve Bk.,Bhor', 'Varve Kh.,Bhor', 'Ketkawale,Purandar',
                    'Chivewadi,Purandar', 'Devadi,Purandar', 'Awhalwadi,Haveli', 'Loni-kand,Haveli',
                    'Kesnand,Haveli', 'Taleranwadi,Haveli', 'Bhavadi,Haveli', 'Perane,Haveli', 'Phulgaon,Haveli',
                    'Wadhu Kh,Haveli', 'Wagholi,Haveli', 'Dhumalicha Mala,Daund', 'Kedgaon,Daund',
                    'Kedgaon Station,Daund', 'Dhaygudewadi,Daund', 'Boripardhi,Daund', 'Yawat Station,Daund',
                    'Yawat,Daund', 'Chandkhed,Mawal', 'Darumbare,Mawal', 'Vadgaon,Mawal', 'Golegaon,Khed',
                    'Narhe,Haveli'
                ];
                $(".search").autocomplete({
                    source: availableTags
                });
            });
        </script>
        <style>
            .profile-username {
                align-content: center;
                font-weight: bold;
                color: #0d6efd;
                text-transform: capitalize;
                font-size: 20px;
                text-align: right;
                margin-right: 10%;
                margin-top: -30px;

            }

            #log-btn {


                position: absolute;

                display: inline-block;
                border: green;
                padding: 5px;
                border-radius: 7px;
                bottom: 5%;
                left: 90%;


            }


            #box {
                margin: 20px 30px;
                background-color: orangered;
            }

            /* .export{
        border: 2px solid green;
        padding: 5px;
        position: absolute;
        float:right;
        right:7%;
        top:12%;
       margin-left: 80%; 
        

    } */

            #closeBtn {
                /* margin-left:90%;  */
                position: absolute;
                float: right;
                right: 20px;
                top: -10px;
                /* margin-top:-40px; */
                padding: 5px;
                background-color: red;
                border: 2px solid red;
                color: aliceblue;

            }

            #table-container {
                border: 2px double white;
                margin-left: 15px;
                margin-top: 70px;
                width: 87%;
                height: 650px;
                overflow: scroll;
                color: aliceblue;
                background-color: black;
            }

            @media screen and (min-width:768px) {
                #table-container {
                    border: 2px double white;
                    margin-left: 200px;
                    margin-top: 20px;
                    width: 500px;
                    height: 700px;
                    overflow: scroll;
                    color: aliceblue;
                    background-color: black;
                }


                #closeBtn {
                    /* margin-left:90%;  */
                    position: absolute;
                    float: right;
                    right: 50px;
                    top: 10px;
                    /* margin-top:-40px; */
                    padding: 5px;
                    background-color: red;
                    border: 2px solid red;
                    color: aliceblue;

                }
            }


            @media screen and (min-width:1024px) {

                #table-container {
                    border: 2px double white;
                    margin-left: 300px;
                    margin-top: 20px;
                    width: 700px;
                    height: 750px;
                    overflow: scroll;
                    color: aliceblue;
                    background-color: black;
                }


                #closeBtn {
                    /* margin-left:90%;  */
                    position: absolute;
                    float: right;
                    right: 20px;
                    top: -10px;
                    /* margin-top:-40px; */
                    padding: 5px;
                    background-color: red;
                    border: 2px solid red;
                    color: aliceblue;

                }
            }

            @media screen and (min-width:1440px) {

#table-container {
    border: 2px double white;
    margin-left: 300px;
    margin-top: 20px;
    width: 1100px;
    height: 750px;
    overflow: scroll;
    color: aliceblue;
    background-color: black;
}


#closeBtn {
    /* margin-left:90%;  */
    position: absolute;
    font-weight: bold;
    float: right;
    right: 20px;
    top: -10px;
    /* margin-top:-40px; */
    padding: 5px;
    background-color: red;
    border: 2px solid red;
    color: aliceblue;

}
}
        </style>
    </head>

    <body class="fixed-nav sticky-footer " style="background-color:#dddddd;">

        <div>
            <h3 class=" text-primary fw-bold ms-5">TCPL</h3>

            <h3 class="profile-username ">
                <?php
                echo $_SESSION['username'];
                ?>
            </h3>

            <!-- <p class="text-muted text-center">
                                <?php
                                echo $user['email'];
                                ?>
                            </p> -->

            <div id="box" class="text-secondary">
                <span id="button">Make Query</span>
                <form action="" id="form">
                    <div id="filter-tag">
                        <table>
                            <tr>
                                <td><label for="layer">Select Layer</label></td>
                                <td><select class="form-control" id="layer" name="layer">
                                        <option value="">Select Layer</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="attributes">Select Column</label>
                                </td>
                                <td>
                                    <select class="form-control" id="attributes" name="attributes">
                                        <option value="">Select Attributes</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="operator">Select operator</label>
                                </td>
                                <td>
                                    <select class="form-control" id="operator" name="operator">
                                        <option value="">Select operator</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="value">Enter Value</label>
                                </td>
                                <td>
                                    <select class="form-control" id="selectvalue" name="selectvalue">
                                        <option value="">selectvalue</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <a href="#">
                                    <button class="btn btn-success" id="loadquery" type="button">Export</button></a>
                            </tr>
                            <tr>
                                <p id="textval">
                                </p>
                            </tr>
                        </table>
                    </div>
                </form>

            </div>

            <!-- <form action="Logout.php" method="post">
                                <button class="tablinks text-center bg-success text-light" id="log-btn" name="Logout" type="submit"><i class="fas fa-sign-out"></i>
                                    Logout</button>
                            </form> -->
        </div>





        <!-- -----------------------------------------The table structure which grows in number as the data to be displayed grows---------------------------------------- -->

        <a href="index.php"> <button id="closeBtn">X</button></a>
        <div id="table-container">





            <table id="filtered-data-table">
                <thead>
                    <tr class=" overflow :auto ; width: fit-content; block-size: fit-content;">
                        <th></th>
                        <th></th>
                        <th></th>
                        <!-- add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- ----------------------------------------------------------------------------------------------------------- -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function SearchMe() {
                var array = $('.search').val().split(",");

                if (array.length == 1) {
                    var sql_filter1 = "Gut_Number Like '" + array[0] + "'"
                    fitbou(sql_filter1)
                    wms_layer1.setParams({
                        cql_filter: sql_filter1,
                        styles: 'highlight',
                    });
                    wms_layer1.addTo(map);
                } else if (array.length == 2) {
                    var sql_filter1 = "Village__1 Like '" + array[0] + "'" + "AND Taluka Like '" + array[1] + "'"
                    fitbou(sql_filter1)
                    wms_layer1.setParams({
                        cql_filter: sql_filter1,
                        styles: 'highlight',
                    });
                    wms_layer1.addTo(map);
                } else if (array.length >= 3) {
                    var guts = array.slice(2, array.length).join(", ")
                    var sql_filter1 = "Village__1 Like '" + array[0] + "'" + "AND Gut_Number IN (" + guts + ")" +
                        "AND Taluka Like '" + array[1] + "'"
                    fitbou(sql_filter1)
                    wms_layer1.setParams({
                        cql_filter: sql_filter1,
                        styles: 'highlight',
                    });
                    wms_layer1.addTo(map);
                }
            }

            function fitbou(filter) {
                var layer = 'DP:Revenue'
                var urlm = "http://89.116.179.78:8080/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" +
                    layer + "&CQL_FILTER=" + filter + "&outputFormat=application/json";
                console.log(urlm)
                $.getJSON(urlm, function(data) {
                    var tableRows = '';
                    data.features.forEach(function(feature) {
                        var column1 = feature.properties.column1;
                        var column2 = feature.properties.column2;
                        var column3 = feature.properties.column3;
                        // add more columns as needed
                        tableRows += '<tr><td>' + column1 + '</td><td>' + column2 + '</td><td>' + column3 + '</td></tr>';
                    });
                    $('#filtered-data-table tbody').html(tableRows);
                });
            };

            function ClearMe() {
                map.setView([18.55, 73.85], 10, L.CRS.EPSG4326)
            };

            $("#button").click(function() {
                $("#box form").toggle("slow");
                $(document).ready(function() {
                    $.ajax({
                        type: "GET",
                        url: "http://89.116.179.78:8080/geoserver/DP/wfs?request=getCapabilities",
                        dataType: "xml",
                        success: function(xml) {
                            var select1 = $('#layer');

                            $(xml).find('FeatureType').each(function() {
                                $(this).find('Name').each(function() {
                                    var value = $(this).text();
                                    select1.append(
                                        "<option class='ddindent' value='" +
                                        value + "'>" + value + "</option>");
                                });
                            });
                        }
                    });
                });
                $(function() {
                    $("#layer").change(function() {
                        var attributes = document.getElementById("attributes");
                        var length = attributes.options.length;
                        for (i = length - 1; i >= 0; i--) {
                            attributes.options[i] = null;
                        }
                        var value_layer1 = $(this).val();
                        $(document).ready(function() {
                            $.ajax({
                                type: "GET",
                                url: "http://89.116.179.78:8080/geoserver/wfs?service=WFS&request=DescribeFeatureType&version=1.1.0&typeName=" +
                                    value_layer1,
                                dataType: "xml",

                                success: function(xml) {

                                    var select2 = $('#attributes');
                                    $(xml).find('xsd\\:sequence').each(function() {
                                        $(this).find('xsd\\:element').each(
                                            function() {
                                                var value = $(this)
                                                    .attr('name');
                                                var type = $(this).attr(
                                                    'type');
                                                if (value != 'geom' &&
                                                    value != 'the_geom'
                                                ) {
                                                    select2.append(
                                                        "<option class='ddindent' value='" +
                                                        type +
                                                        "'>" +
                                                        value +
                                                        "</option>");
                                                }
                                            });
                                    });
                                }
                            })
                        });
                        document.getElementById("textval").innerHTML = value_layer1;
                    })
                });
                console.log("ajfb")
                $(function() {
                    $("#attributes").change(function() {
                        var operator = document.getElementById("operator");
                        var attributes = $("#layer option:selected").text();
                        var length = operator.options.length;
                        for (i = length - 1; i >= 0; i--) {
                            operator.options[i] = null;
                        }
                        var value_type = $(this).val();
                        var value_attribute = $('#attributes option:selected').text();
                        operator.options[0] = new Option('Select operator', "");
                        if (value_type == 'xsd:short' || value_type == 'xsd:int' || value_type ==
                            'xsd:double') {
                            var operator1 = document.getElementById("operator");
                            operator1.options[1] = new Option('>', '>');
                            operator1.options[2] = new Option('<', '<');
                            operator1.options[3] = new Option('=', '=');
                            operator1.options[4] = new Option('<=', '<=');
                            operator1.options[5] = new Option('=>', '=>');
                            operator1.options[6] = new Option('IN ()', 'IN');
                            operator1.options[7] = new Option('OR ||', 'OR');
                            operator1.options[8] = new Option('AND &', 'AND');
                        } else if (value_type == 'xsd:string') {
                            var operator1 = document.getElementById("operator");
                            operator1.options[1] = new Option('Like', 'ILike');
                            operator1.options[2] = new Option('IN ()', 'IN');
                            operator1.options[3] = new Option('OR ||', 'OR');
                            operator1.options[4] = new Option('AND &', 'AND');
                        }


                        var selectvalue = document.getElementById("selectvalue");
                        var length = selectvalue.options.length;
                        for (i = length - 1; i >= 0; i--) {
                            selectvalue.options[i] = null;
                        }

                        $(document).ready(function() {
                            $.ajax({
                                type: "GET",
                                url: "http://89.116.179.78:8080/geoserver/wfs?service=wfs&version=1.0.0&request=getfeature&typename=" +
                                    attributes + "&PROPERTYNAME=" + value_attribute,
                                dataType: "xml",
                                success: function(xml) {
                                    var select3 = $('#selectvalue');
                                    var unq = new Array();
                                    $(xml).each(function() {
                                        $(this).find('gml\\:featureMember')
                                            .each(function() {
                                                unq.push($(this)
                                                    .text());
                                            });
                                        let unique = unq.filter((item, i,
                                            ar) => ar.indexOf(
                                            item) === i);
                                        for (let i = 0; i < unique
                                            .length; i++) {
                                            select3.append(
                                                "<option class='ddindent' value='" +
                                                unique[i] + "'>" +
                                                unique[i] + "</option>");
                                        }
                                    });
                                }
                            });
                        });
                        document.getElementById("textval").innerHTML = "From Layer" + attributes +
                            " is " + value_attribute;
                    });

                });
            });



            $(function() {
                $("#selectvalue").change(function() {
                    var vars = ['layer', 'attributes', 'operator', 'selectvalue'];
                    for (let i = 0; i < vars.length; i++) {
                        //   var operator = document.getElementById("operator");
                        var layer = $("#layer option:selected").text();
                        var attributes = $("#attributes option:selected").text();
                        var operator = $("#operator option:selected").text();
                        var selectvalue = $("#selectvalue option:selected").text();
                    }
                    document.getElementById("textval").innerHTML = "From Layer " + layer + " column is " +
                        attributes + " " + operator + " value is " + selectvalue;

                    var sql_filter1 = attributes + " Like '" + selectvalue + "'"
                    console.log(sql_filter1)
                    fitbout(sql_filter1, layer)

                    var wms_layerf = L.tileLayer.wms(
                        "http://89.116.179.78:8080/geoserver/DP/wms", {
                            layers: layer,
                            format: "image/png",
                            transparent: true,
                            tiled: true,
                            version: "1.1.0",
                            attribution: "ugc",
                            opacity: 1,
                            cql_filter: sql_filter1,
                            styles: 'highlight',

                        }
                    );
                    // wms_layerf.addTo(map);


                    function fitbout(filter, layer1) {
                        var urlm =
                            "http://89.116.179.78:8080/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" +
                            layer1 + "&CQL_FILTER=" + filter + "&outputFormat=application/json";
                        console.log(urlm)
                        $.getJSON(urlm, function(data) {
                            // create HTML table
                            var table = document.createElement('table');

                            // create table header
                            var tableHeader = table.createTHead();
                            var row = tableHeader.insertRow();
                            for (var key in data.features[0].properties) {
                                var th = document.createElement('th');
                                th.appendChild(document.createTextNode(key));
                                row.appendChild(th);
                            }

                            // create table body
                            var tableBody = table.createTBody();
                            for (var i = 0; i < data.features.length; i++) {
                                var feature = data.features[i];
                                var row = tableBody.insertRow();
                                for (var key in feature.properties) {
                                    var cell = row.insertCell();
                                    cell.appendChild(document.createTextNode(feature.properties[key]));
                                }
                            }

                            // add table to the HTML document
                            var tableContainer = document.getElementById('table-container');
                            tableContainer.innerHTML = '';
                            tableContainer.appendChild(table);

                            // fit map bounds to the filtered data
                            geojson = L.geoJson(data, {});
                            // map.fitBounds(geojson.getBounds());
                        });
                    };



                });
            })

            // -----------------------------------------
        </script>



    </body>

    </html>