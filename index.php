
<?php
session_start();
?>

<?php
if(isset($_REQUEST['submit'])){
   # $substitucion = array( "&", "&&", ";", "|", "||", "$", "$$", "(", ")", "'", "or", "OR", "-", "--", "#", "##");
    
 #   $target = $_REQUEST['uname'];
 #   $target = str_replace( $substitucion, "", $target);
#    $target2 = $_REQUEST['psw'];
  #  $target2 = str_replace( $substitucion, "", $target2);
    
                    $servername = "localhost";
                    $database = "Empresa";
                    $username = "admin";
                    $password = "user";
                    $conn = mysqli_connect($servername, $username, $password, $database);
    
                    if (!$conn) {
                       
                        die("ConnexiÃ³ errÃ²nea: " . mysqli_connect_error());
                   
                    }
                   
                    $sql = "SELECT * FROM Usuarios";
    
                    $res = mysqli_query($conn, $sql);
                    while ($fila = $res->fetch_assoc())
                    {
                        echo $fila['Id_user']."<br>";
                        echo $fila['Nombre']."<br>";
                        echo $fila['Password']."<br>";
                        echo $fila['Id_Depart']."<br>";
                    }
                }
                else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="icon" type="image/x-icon" href="./logo.png" alt="Logo de nuestra empresa de componentes informáticos COMPONENTES-SPD">
    <title>Proyecto final</title>
</head>
<body>
    
    <header>

        <h1 id="h1head">DPS Industry</h1>

 
            <div class="head_div">
                <ul class="head_list"> <li> &nbsp;Contactanos</li> <b><li> &nbsp;Sobre nosotros</li></b> <li> <a href="index.html">&nbsp;Castellano</a></li> <li> <a href="indexcat.html">&nbsp;Catalan</a></li> <li><a href="indexing.html">&nbsp;Ingles</a></li><li><a href="login.html"><button id="Boton" name="submit" type="submit"> LOGIN</button></a></li></ul>
            </div>


    </header>

    <section id="Per1">
        
        <div id="Per1Div">

            <img src="incognito.webp" id="incognito">
        
            <h1 id="SEA">Sergi Estrella Amat</h1>
        
            <p id="ParrPer1">
                Bienvenido a nuestra web, soy Sergi Estrella Amat. Uno de los creadores y
                diseñadores de esta web y ahora mismo resido en España - Barcelona.
                Hasta el momento he cursado un ciclo medio de sistemas microinformáticos en
                red y ahora mismo estoy terminando el segundo año de ciclo superior. Estoy
                cursando este ciclo con la idea de hacer un master y un doctorado de forma
                intensiva con la mentalidad de terminar en uno o dos años mientras hago algún
                trabajo a media jornada preferiblemente en una empresa destinada al sector
                web o al sector de ciberseguridad.
                Estoy cursando estos ciclos en parte motivado por mis antiguos profesores
                además de gustos personales por este sector. Personalm ente tengo la idea de
                trabajar unos años en empresas para después ver si prefiero trabajar de forma
                autónoma o entrar como un profesor universitario. Mi preferencia suele ser
                ambientada hacia el sector de seguridad.
                Ya que soy una persona que le gusta estar ocupada pienso que los turnos de
                mañana son los más indicados para mí ya que no me agrada la idea de tener
                toda la mañana sin ocupación, por el momento no he tenido ningún trabajo
                mediante contrato por lo tanto estoy disp uesto a probar diversos puestos dentro
                de una empresa siempre y cuando no implique estar todo el día atendiendo a
                gente externa a la propia empresa.
                Aunque quizá en este breve texto no se pueda apreciar soy una persona
                ordenada a la que le gusta aplicar lo aprendido a cualquier cosa, so y una
                persona constante y aplicada al trabajo, incluso suelo ser bueno para dividir
                trabajos en caso de hacerlo junto con un equipo. Soy una persona fácil de
                conocer y siempre intento dar apoyo a las personas con las que convivo.
                Dicho esto, concluyo mi porfolio sobre mí. Espero y disfrute de la página.
            </p>
        
        </div>

    </section>

    <section id="Per2">
        
        <div id="Per2Div">

            <img src="incognito.webp" id="incognito">
        
            <h1 id="DFG">David Fernandez Gonzalez</h1>
        
            <p id="ParrPer2">
                Bienvenido a nuestra web soy David Fernández González y resido en Barcelona estoy
                realizando el curso de ciclo superior de administración de sistemas en red y
                ciberseguridad y anteriormente he cursado un ciclo de grado medio de sistemas
                microinformáticos en red y un PFI de auxiliar de montaje y mantenimiento de
                sistemas microinformáticos mis planes para el próximo año es acabar mis estudios y
                continuar estudiando un máster mientras trabajo en algo relacionado con mis
                estudios actualmente no tengo una preferencia de sobre que me gustaría trabajar en
                un futuro estoy abierto a poder aprender sobre todos los ámbitos soy una persona
                que no tiene problemas al momento de trabajar en equipo llegar a la hora y ser
                responsable con mi equipo y mi trabajo soy una persona que no se rinde de buenas
                a primeras e intenta todo lo que puede y que planifica siempre los tiempos de sus
                trabajos y momentos de ocio que no tiene problema en hablar con alguien que no
                sea de su equipo y que tiene ganas de aprender y aprovechara las oportunidades
                que le den para ello mis aficiones son los videojuegos el rap y el anime algo que me
                hace diferente es que intento siempre ponerme en la piel de otras personas para
                saber lo que están pasando.
            </p>
        
        </div>

    </section>

    <section id="Per3">
        
        <div id="Per3Div">

            <img src="incognito.webp" id="incognito">
        
            <h1 id="PPT">Pau Paus Torres</h1>
        
            <p id="ParrPer3">
                ¡Hola! Soy Pau Paús Torres, tengo 20 años y resido en Barcelona. Me apasiona la informática y mi
                recorrido incluye estudios en SMIX, un año de DAW, y actualmente me encuentro estudiando
                ASIX con enfoque en ciberseguridad.
                Una vez finalice el curso actual, tengo la intención de seguir estudiando. Estoy indeciso entre
                enfocarme en un máster en ciberseguridad especializado en forense o adentrarme en el mundo
                de la inteligencia artificial.
                Desde pequeño, la informática ha sido una parte fundamental de mi vida, inspirado en mi
                hermano mayor que también eligió este camino. Mi deseo es trabajar en la informática forense o
                la inteligencia artificial, áreas que considero apasionantes. No obstante, estoy dispuesto a
                explorar otras ramas de la informática.
                Me considero una persona confiable y me destaco por mi habilidad para trabajar en equipo y
                ayudar a los demás. En mi tiempo libre, disfruto jugando videojuegos, al mismo tiempo que me
                mantengo al tanto de las últimas noticias en el mundo de la inteligencia artificial y la
                ciberseguridad.
            </p>
        
        </div>

    </section>

    <section id="Contacto">
        
        <div id="ContactaDiv">
            <h1 id="ContactaH1">Contactanos</h1>
            
            <div id="RedesImagen">
                <img src="nemp.png" id="RedesImg">

                <p id="Redes">
                    Puedes contactarnos mediante <b>Gmail</b> como Futbi70@gmail.com<br><br>
                    Tambien contactanos mediante nuestro <b>numero telefonico</b> llamando al 657938271
                </p>

                <h1 id="Agradecimientos"> Gracias por confiar en DPS</h1>
            </div>

            

        </div>

        
    

    </section>

</body>
</html>
<?php
}
?>