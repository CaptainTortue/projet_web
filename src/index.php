<!DOCTYPE html>
<?php
    session_start();
    $_SESSION["login"] = true;
    if (!isset($_SESSION["size_texte"])) {
        $_SESSION["size_texte"] = 1;
    }
?>
<html lang="fr">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- hightchart -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <!-- pour le wordcloud en particulier -->
        <script src="https://code.highcharts.com/modules/wordcloud.js"></script>

        <link rel="stylesheet" href="../css/acueil.css">

        
        <?php
            include("../include/connexion.inc.php");
            include("../scripts/getTheses.php");
            include("../manipulationTheses/getNumberOfTheses.php");
            include("../manipulationTheses/getNumberOfDirectors.php");
            include("../manipulationTheses/getNumberOfEtablishment.php");
            include("../manipulationTheses/getNumberOfThesesAccessible.php");
            include("../manipulationTheses/getStatsAccessible.php");
            include("../manipulationTheses/getStatsDiscipline.php");
            include("../manipulationTheses/getStatsEmbargo.php");
            include("../manipulationTheses/getStatsLangue.php");
            include("../scripts/getstatsByDate.php");
            include("../scripts/getAllBiGSubjects.php");
            $theses = get_these($cnx);
            $numberOfThese = getNumberOfTheses($theses);
            $numberOfDirectors = getNumberOfDirectors($cnx, $theses);
            $numberOfEtablishment = getNumberOfEtablishment($theses);
            $numberOfTheseAccessible = getNumberOfThesesAccessible($theses);
            $statsAccessible = getStatsAccessible($theses);
            $statsDiscipline = getStatsDiscipline($theses);
            $statsEmbargo = getStatsEmbargo($theses);
            $statsLangue = getStatsLangue($theses);
            $allBiGSubjects = getAllBiGSubjects($cnx);
            if (!isset($_POST["date"])) {
                $statsDate = getStatsDate($cnx, 'year');
            } else {
                $statsDate = getStatsDate($cnx, $_POST["date"]);
            }
        ?>

        
</head>
    <body>
    <?php if (!isset($_SESSION["login"])) {header('Location: ../index.php');} ?>
    <h1 class="titre">Thèses</h1>


    
    <form action="index.php" method="POST">
        <div class="group_form">
            <div class="computer_flex wrap">
                <div class="element_form computer_flex">
                    <b>Type de personne: </b>
                    <select name="type" id="type">
                        <option value="auteurs">Auteur</option>
                        <option value="directeurs">Directeur</option>
                        <option value="rapporters">Rapporter</option>
                    </select>
                </div>
                <div class="element_form">
                    <b>Nom: </b> <input type="text" name="nom"/>
                </div>
                <div class="element_form">
                    <b>Prenom: </b> <input type="text" name="prenom"/>
                </div>
                <div class="element_form">
                    <b>Titre: </b><input type="text" name="titre"/>
                </div>
                <div class="element_form">
                    <b>Discipline: </b><input type="text" name="discipline"/>
                </div>
            </div>
            <input type="reset" name="reset" value="Effacez"/> <input type="submit" name="submit" value="Rechercher"/>
            <button onclick="location.href = './alert/';">Gestion des alertes</button>

        </div>
    </form>


    <div id="container"></div>

    <div class="stats">
        <h4>Quelques statistiques sur les thèses :</h4>

        <div class="computer_flex center wrap">
            <h5>Nombre de thèses soutenu: <?php echo $numberOfThese?></h5>
            <h5>Nombre de thèses en ligne: <?php echo $numberOfTheseAccessible?></h5>
            <h5>Nombre de directeurs: <?php echo $numberOfDirectors?></h5>
            <h5>Nombre d'établissment qui soutiennent des thèses: <?php echo $numberOfEtablishment?></h5>
        </div>

        <div class="computer_flex center">
            <div id="statsAccessible"></div>
            <div id="statsEmbargo"></div>
        </div>

        <div class="computer_flex center">
            <div id="statsDiscipline"></div>

            <div id="statsLangue"></div>
        </div>

        <form action="/index.php" name="date" method="POST">
        <label for="date">By :</label>
        <select id="date" name="date">
            <option value="year">Year</option>
            <option value="month">Month</option>
        </select>
        </form>
        <div id="statsByDate"></div>
    </div>


    <script>
    const text = "<?php
        foreach ($allBiGSubjects as $subject) {
            echo $subject["sujet"]." ";
        }
    ?>"
    lines = text.replace(/[():'?0-9]+/g, '').split(/[,\. ]+/g),
    data = lines.reduce((arr, word) => {
        let obj = Highcharts.find(arr, obj => obj.name === word);
        if (obj) {
            obj.weight += 1;
        } else {
            obj = {
                name: word,
                weight: 1
            };
            arr.push(obj);
        }
        return arr;
    }, []);

Highcharts.chart('container', {
    accessibility: {
        screenReaderSection: {
            beforeChartFormat: '<h5>{chartTitle}</h5>' +
                '<div>{chartSubtitle}</div>' +
                '<div>{chartLongdesc}</div>' +
                '<div>{viewTableButton}</div>'
        }
    },
    series: [{
        type: 'wordcloud',
        data,
        name: 'Occurrences'
    }],
    credits: {
        enabled: false
    },
    title: {
        text: '',
        align: 'left'
    },
    tooltip: {
        headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
    }
});
         


        // Make monochrome colors
        var pieColors = (function () {
            var colors = [],
                base = Highcharts.getOptions().colors[0],
                i;

            for (i = 0; i < 10; i += 1) {
                // Start out with a darkened base color (negative brighten), and end
                // up with a much brighter color
                colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
            }
            return colors;
        }());

        // pie of these accessible or not
        const chartAccessible = Highcharts.chart('statsAccessible', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Pourcentage des thèses accessible ou non'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: pieColors,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 4
                        }
                    }
                }
            },
            series: [{
                name: 'Share',
                data: [
                    { name: 'Accessible', y: <?php echo $statsAccessible[0]; ?> },
                    { name: 'Pas Accessible', y: <?php echo $statsAccessible[1]; ?> },
                ]
            }]
        });


        // pie of these by discipline
        const chartDiscipline = Highcharts.chart('statsDiscipline', {
            chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Pourcentages de thèses en foncton de la discipline'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
            series: [{
                name: 'Share',
                colorByPoint: true,
                data: [
                    <?php 
                        foreach($statsDiscipline as $stat) {
                            echo '{ name: "'.$stat["discipline"].'", y: '.$stat["nbThese"].'},';
                        }
                    ?>
                ]
            }]
        });

        
        // pie of these by langue
        const chartLangue = Highcharts.chart('statsLangue', {
            chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Pourcentages de thèses en foncton de la langue'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
            series: [{
                name: 'Share',
                colorByPoint: true,
                data: [
                    <?php 
                        foreach($statsLangue as $stat) {
                            echo '{ name: "'.$stat["langue"].'", y: '.$stat["nbThese"].'},';
                        }
                    ?>
                ]
            }]
        });

        
        // pie of these by Embargo
        const chartEmbargo = Highcharts.chart('statsEmbargo', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Pourcentage des thèses avec embargo ou non'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: pieColors,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 4
                        }
                    }
                }
            },
            series: [{
                name: 'Share',
                colorByPoint: true,
                data: [
                    { name: 'Avec embargo', y: <?php echo $statsEmbargo[0]; ?> },
                    { name: 'Sans embargo', y: <?php echo $statsEmbargo[1]; ?> },
                ]
            }]
        });


        // graphique nombre de these par annee
        Highcharts.chart('statsByDate', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Nombre de thèse soutenue par année'
            },
            subtitle: {
                text: 'à partir de 1985'
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    <?php
                        for ($i = 1985; $i < 2040; $i++) {
                            echo $i.",";
                        }
                    ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nombre de thèses'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Brand',
                colorByPoint: true,
                data: [
                    <?php 
                        foreach($statsDate as $stat) {
                            echo '{ name: "'.$stat["thedate"].'", y: '.$stat["nbTheses"].'},';
                        }
                    ?>
                ]
            }]
        });


    </script>





<?php
            
    if (isset($theses)) {
        echo '<div class="accordion" id="theses">';
        $id = 0;
        foreach($theses as $these) {
            if (isset($these["titre"])) {
                echo 
                '<div class="accordion-item" style="border-width: 4px; border-color: black;">
                    <h2 class="accordion-header" id="heading'.$id.'">
                    <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$id.'" aria-expanded="true" aria-controls="collapse'.$id.'">
                        <p>'.$these["titre"].'</p>
                    </button>
                    </h2>
                    <div id="collapse'.$id.'" class="accordion-collapse collapse" aria-labelledby="heading'.$id.'" data-bs-parent="#these">
                    <div class="accordion-body"><p>';
                    echo $these["id"]."   ".$these["discipline"]."     ".$these["etablissements_soutenance"]."     ".$these["date_soutenance"]."     ".$these["status"]."     ".$these["langue"]."     ".$these["nnt"]."     ".$these["nom"]."     ".$these["prenom"];
                    if (isset($these["resume"])) {
                        echo $these["resume"];
                    }
                    echo '<a href="https://theses.fr/'.$these["nnt"].'"> Accéder à la thèse</a>';
                    echo '</p></div>
                    </div>
                </div>';
                $id += 1;
            }
        }
    }
    ?>
    </div>

    <footer> 
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <p class="navbar-nav mb-2 mb-lg-0">Tristan Martinez</p>
                    <a class="nav-link active" aria-current="page" href = './reporting.html'>Reporting</a>

                        <b>Taille de texte : </b>
                        <select id="text_size" name="date">
                            <option value="1">Normal</option>
                            <option value="1.2">Large</option>
                            <option value="1.5">Très large</option>
                        </select>
        </div>
    </nav>
    </footer>   
</body>
<script>

    let select = document.getElementById('text_size');

    select.addEventListener('change', () => {
        var r = document.querySelector(':root');
        const taillePolice = select.value;
        r.style.setProperty('--text_size', taillePolice);
        console.log(select.value)
        console.log(getComputedStyle(document.documentElement)
            .getPropertyValue('--my-variable-name'))
    });
</script>
</html>
