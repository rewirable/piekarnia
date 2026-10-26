<?php
    $link = mysqli_connect("localhost", "root", "", "piekarnia");
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Produkty</title>
</head>
<body>
    <header>
        <h1>Produkty</h1>
    </header>
    <main>
        <div id="kategorie">

        <?php
        $kategorie = mysqli_query($link,"SELECT * FROM kategorie;");
        foreach($kategorie as $rows){
            echo '<label>
            <input type="checkbox" class="kategoria" value="'.$rows['id_kategorii'].'">
            '.$rows['nazwa'].'
            </label>';
        }
        ?>
        </div>
        <section>
            <?php
                if(isset($_POST['kategorie']) && is_array($_POST['kategorie'])){
                    foreach($_POST['kategorie'] as $rowaa){
                        
                            $row = mysqli_query($link, "SELECT * FROM produkty WHERE kategoria_id = $rowaa;");
                                foreach($row as $rows){
                                    echo '<div>
                                    <h2>'. $rows['nazwa'] .'</h2>
                                    <img src="'.$rows['zdjecie'].".png".'"/>
                                    <h5>Cena: '.$rows['cena'].' zł</h5>
                                    </div>';
                            };     
                    }
                }

            ?>
            
        </section>
    </main>
    <footer>
        <h2>Masz pytania?</h2>
        <p>Zadzwoń do nas lub napisz:</p>
        <ul>
            <b><li>+48 658 - 412 - 743</li>
            <li>piekarnia.kozlowski@gmail.com</li></b>
        </ul>
        <small>© 2026 Piekarnia Kozłowski</small>

        </i>
    </footer>
<script>
        document.querySelectorAll('.kategoria').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let selected = [...document.querySelectorAll('.kategoria:checked')]
                    .map(cb => cb.value);

                fetch(location.pathname, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: selected.map(id => 'kategorie[]=' + id).join('&')
                })
                .then(r => r.text())
                .then(html => {
                    let doc = new DOMParser().parseFromString(html, 'text/html');
                    document.querySelector('section').innerHTML =
                        doc.querySelector('section').innerHTML;
                });
            });
        });
</script>
</body>
</html>
<?php
    #mysqli_close($link);
?>