<?php require 'php/config.php';?>

<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <section class="noticia-galeria">
        <div class="container">
            <div class="row">
                <h3 class="fondoPrincipal-text center">TÍTULO DE LA NOTICIA</h3>
                <hr>
                <div class="slider" id="noticia-slider">
                    <ul class="slides">
                        <li>
                            <img src="img/noticiaPortada.jpg" alt="" class="responsive img">
                        </li>
                        <li>
                            <img src="img/noticiaPortada.jpg" alt="" class="responsive img">
                        </li>
                        <li>
                            <img src="img/noticiaPortada.jpg" alt="" class="responsive img">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="cuerpo-noticia">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <p>27 Julio 2018</p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at feugiat urna. Proin pulvinar tempor mauris nec iaculis. Nullam ut risus convallis, semper enim sed, accumsan sapien. Phasellus urna magna, venenatis sit amet maximus non, consequat nec est. Integer massa mi, aliquam non tempus non, convallis nec justo. Nulla non dapibus tellus. Pellentesque eleifend fringilla malesuada.
                    </p>
                    <p>
                        Cras at est tortor. Suspendisse ut eros quis metus lobortis lacinia non non nunc. Vestibulum quis vestibulum erat. Suspendisse tempor, lectus in commodo eleifend, erat massa venenatis urna, non varius mi turpis nec quam. Ut id tellus tristique, rhoncus risus at, scelerisque dui. Aenean sed urna id mauris pretium sagittis a tristique dolor. Nunc bibendum dolor sapien, vitae aliquet sem varius vel. Sed cursus urna sit amet dolor maximus, quis congue est faucibus. Donec volutpat diam id nisl ornare, in fringilla eros sollicitudin. Nam vestibulum eu orci ut posuere. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent aliquam neque sed auctor tempus. Sed feugiat dolor dui, eget sagittis nibh pharetra sit amet. Curabitur dictum sed nulla non vestibulum. Mauris venenatis felis vel pellentesque euismod. Ut vel ex at urna posuere feugiat sed ac tortor.
                    </p>
                    <p>
                        Cras quis dolor leo. Morbi viverra mauris at tortor convallis consequat et lacinia est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi posuere diam nec ligula aliquet faucibus sit amet nec lectus. Vestibulum eu rutrum orci, sit amet lobortis lacus. Duis maximus dui turpis, eu gravida justo volutpat at. Donec sagittis ipsum in congue hendrerit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam diam massa, convallis eu varius vitae, iaculis vitae justo.
                    </p>
                    <p>
                        Morbi a mollis odio. Donec id neque dictum, consequat lectus a, consectetur massa. Etiam ut neque mauris. Morbi mattis luctus lacus eu interdum. Aliquam facilisis aliquam commodo. Sed quis condimentum metus. Sed euismod augue eu diam hendrerit, vel eleifend urna faucibus. Maecenas erat justo, accumsan ac odio id, facilisis vehicula nulla. Mauris ultricies nunc ut augue porttitor, lobortis tincidunt arcu molestie. Donec laoreet lectus non tortor rutrum, eget tempus dui lobortis. Nullam malesuada porta neque, at pretium neque tincidunt at. Aliquam malesuada rhoncus posuere. Morbi a dui vel diam semper mattis. Pellentesque iaculis velit in odio commodo, vel suscipit urna gravida. Fusce ultricies sem non diam ornare, quis consectetur ligula eleifend. Nam sollicitudin elementum enim eu posuere.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $('#noticia-destacada').slider({
            indicators: false,
            height: 400
        });
    </script>

</body>

</html>
