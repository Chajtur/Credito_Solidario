<?php require 'php/config.php';?>

<!DOCTYPE html>
<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <section class="quienes-somos">
        <div class="container">
            <div class="row">
                <div class="col s12 m4">
                    <img src="img/400X400-02.jpg" alt="" class="img-quienes-somos">
                </div>
                <div class="col s12 m8 center">
                    <h3 class="fondoPrincipal-text">¿QUIÉNES SOMOS?</h3>
                    <hr class="fondoPrincipal-text">
                    <p>EL PROGRAMA CRÉDITO SOLIDARIO BUSCA:</p>
                    <p>Somos un programa creado con la visión del Presidente de la República, cuya finalidad es la de brindar asistencia técnica y dar acceso a créditos solidarios a todos los emprededores del país que quieran o estén organizados y que tengan el deseo de construir una microempresa.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="estrategia">
        <div class="container">
            <div class="row center">
                <div class="col s12 m4">
                    <h3 class="fondoPrincipal-text">MISIÓN</h3>
                    <p>Somos un Programa Presidencial al servicio de los emprendedores del sector micro empresarial del país, otorgándoles asistencia técnica y crédito solidario con responsabilidad haciendo énfasis en la recuperación de los recursos con el fin de reutilizar esos fondos en nuevos emprendimientos.</p>
                </div>
                <div class="col s12 m4 vision">
                    <h3 class="fondoPrincipal-text">VISIÓN</h3>
                    <p>Ser, al 2020, el Programa Modelo en Latinoamérica de asistencia técnica y créditos solidarios al servicio del sector micro empresarial del país, operando en forma independiente y con personal altamente motivado y comprometido con la excelencia.</p>
                </div>
                <div class="col s12 m4">
                    <h3 class="fondoPrincipal-text">VALORES</h3>
                    <p>
                        Solidarios e incluyentes<br>
                        Proactivo<br>
                        Creativos<br>
                        Amables<br>
                        Excelencia en operar y servir<br>
                        Responsables e íntegros<br>
                        Transparentes<br>
                        Comprometidos con el trabajo<br>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="memoria-anual">
        <div class="container">
            <div class="row center">
                <h5 class="teal-text">Memoria anual: insertlinkdememoriaanual.com</h5>
            </div>
        </div>
    </section>

    <section class="familia">
        <div class="container">
            <div class="row" id="familia-cs">
            </div>
        </div>
    </section>

    <!--  
    <section class="ifis">
        <div class="container">
            <div class="row">
                <h3 class="fondoPrincipal-text center">INSTITUCIONES FINANCIERAS</h3>
            </div>
        </div>
    </section>
    -->

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function () {
            obtenerFamilia();            
        });

        function obtenerFamilia() {
            let familiaCs = $('#familia-cs');
            let familiaTxt = '<h3 class="fondoPrincipal-text center">FAMILIA CRÉDITO SOLIDARIO</h3>';

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/personalCtrl.php?accion=listar&estado=1',
                success: function (data) {
                    let personal = JSON.parse(data);

                    $.each(personal, function(i, persona) {                        
                        familiaTxt += '<div class="col s12 m3">';
                        familiaTxt += '<div class="familia-img-container">';
                        familiaTxt += '<img src="'+ persona.url +'" alt="" class="responsive-img">';
                        familiaTxt += '<div class="overlay">';
                        familiaTxt += '<div class="text">';
                        familiaTxt += '<p>'+ persona.nombre +'</p>';
                        familiaTxt += '<p class="titulo">'+ persona.cargo +'</p>';
                        familiaTxt += '</div>';
                        familiaTxt += '</div>';
                        familiaTxt += '</div>';
                        familiaTxt += '</div>';
                    });

                    familiaCs.html(familiaTxt);
                }
            });
        }
    </script>

</body>

</html>