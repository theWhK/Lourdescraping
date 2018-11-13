<?php
    require 'backend.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - Lourdescraping</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.5.0/dist/css/foundation.min.css" integrity="sha256-VEEaOnBKVRoYPn4AID/tY/XKVxKEqXstoo/xZ6nemak= sha384-D46t32f421/hB30qwnim2pIcisNN5GU9+6m2Mfnd3dKpTSFidZLa08/1StEiCFId sha512-WkgzH8VKemDfwrp18r+wgbx+oHXOkfd2kJs7ocAXdGDgonXDXh88E90IRtRZRXtO0IHprxYHYlY14h+wyTsUDA==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="grid-container">
            <div class="grid-x">
                <div class="logotipo-wrapper cell small-12 medium-4">
                    <img src="./assets/img/logotipo.png" alt="Lourdescraping">
                </div>
            </div>
        </div>
    </header>
    <div class="header-preenchimento"></div>

    <!-- Filtros -->
    <section class="filtros-wrapper">
        <form class="form-filtros" method="post">
            <div class="grid-container">
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="cell small-12 medium-3">
                        <label for="ddd">Selecione o DDD:</label>
                        <select name="ddd" id="ddd">
                            <option value="11">11</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                        </select>
                    </div>
                    <div class="cell small-12 medium-3">
                        <label for="modalidade">Selecione a Modalidade:</label>
                        <select name="modalidade" id="modalidade">
                            <option value="Particular">Particular</option>
                            <option value="Profissional">Profissional</option>
                            <option value="Ambos">Ambos</option>
                        </select>
                    </div>
                    <div class="cell small-12 medium-3">
                        <label for="tipo">Selecione o Tipo:</label>
                        <select name="tipo" id="tipo">
                            <option value="Casa">Casa</option>
                            <option value="Apartamento">Apartamento</option>
                        </select>
                    </div>
                    <div class="cell small-12 medium-3">
                        <label for="forma">Selecione a Forma:</label>
                        <select name="forma" id="forma">
                            <option value="Venda">Venda</option>
                            <option value="Aluguel">Aluguel</option>
                            <option value="Ambos">Ambos</option>
                        </select>
                    </div>
                    <div class="cell small-12 medium-3">
                        <button class="button" type="submit">Filtrar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!-- Relatório Básico -->
    <section class="relatorio-basico-wrapper">
        <div class="grid-container">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="cell small-12 medium-4">
                    <div class="bloco-info-box">
                        <div class="grid-x">
                            <div class="cell small-12 medium-3">
                                <i class="icone fas fa-money-check-alt"></i>
                            </div>
                            <div class="cell small-12 medium-9">
                                <h4 class="rotulo">Preço do m²</h4>
                                <span class="info">R$ 3.500,00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cell small-12 medium-4">
                    <div class="bloco-info-box">
                        <div class="grid-x">
                            <div class="cell small-12 medium-3">
                                <i class="icone fas fa-money-check-alt"></i>
                            </div>
                            <div class="cell small-12 medium-9">
                                <h4 class="rotulo">Preço médio</h4>
                                <span class="info">R$ 365.000,00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cell small-12 medium-4">
                    <div class="bloco-info-box">
                        <div class="grid-x">
                            <div class="cell small-12 medium-3">
                                <i class="icone fas fa-money-check-alt"></i>
                            </div>
                            <div class="cell small-12 medium-9">
                                <h4 class="rotulo">quant. de imóveis analisados</h4>
                                <span class="info"><?php echo $count ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo var_dump($rows); ?>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.5.0/dist/js/foundation.min.js" integrity="sha256-GZq6aeugpWo25iH//1eKmeK6FHCf+6KXTfoUpkCqPCA= sha384-vjxUQtbGw5FJMigaaFpXYyxoHHLb7LbvRywnMZOiPJeh5j9sl2rnmQ3iucuegRm8 sha512-h7tIMIX/opZXfWkcTDbkO+nT0LePyAAwDacfYhWtgGUidV+Kkh3eesW52fPSxKEsw3rgywKhQvghNLT4eDuUyw==" crossorigin="anonymous"></script>
    <!-- <script src="./assets/js/main.js"></script> -->
</body>
</html>