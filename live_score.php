<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <link rel="stylesheet" href="css/style.css" >
        <link rel="stylesheet" href="font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Ballor Talk-Live Scores</title>
        <link rel="icon" type="image/x-icon" href="img/4_teams.ico">
        <style>
            .flex {
            display: flex;
            justify-content: space-around;
            align-items: center;
            }
        </style>
</head>
<body>

  
  <section class="section them" class teams id="teams" style="background-image: url('img/4_teams.jpeg');">
            <div class="title" >
                <h1 style="color:white; font-weight:bold">LIVE SCORES</h1>
            </div>
            <div class="team-center container" >
                <div class="team">
                    <div class="img-cover">
                        <img src="img/football.jpeg" alt="">
                    </div>
                    <h1>Get Live Score</h1>
                    <div class="App">
                    <button id="showButton" class="btn btn-success">Live Score</button>
                    <div id="liveScores" style="display: none;">
                    <div id="liveScoresContainer" class="flex">
                        <div>
                        <img id="homeTeamLogo" />
                        <h2 id="firstValue"></h2>
                        </div>
                        <div style="font-weight: bold; font-size: 4rem; text-align: center;">
                        vs
                        </div>
                        <div>
                        <img id="awayTeamLogo" />
                        <h2 id="secondValue"></h2>
                        </div>
                    </div>
                    <h1 id="noMatches" style="display: none;">No Live Matches Currently</h1>
                    </div>
                </div>
                    
                </div>
                
            </div>
        </section>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const showButton = document.getElementById("showButton");
      const liveScoresDiv = document.getElementById("liveScores");
      const homeTeamLogo = document.getElementById("homeTeamLogo");
      const awayTeamLogo = document.getElementById("awayTeamLogo");
      const firstValue = document.getElementById("firstValue");
      const secondValue = document.getElementById("secondValue");
      const noMatches = document.getElementById("noMatches");

      let showdiv = false;
      let livescores = [];

      const handleClick = async () => {
        try {
          const apiKey = "5f4b42c1d5ac703c0ed3596590d0bb70d8962f1e06a1d8990b29a6d5bd72c9e1";
          const res = await fetch(`https://apiv2.allsportsapi.com/football/?met=Livescore&APIkey=${apiKey}`);

          if (res.ok) {
            const data = await res.json();
            console.log(data);
            livescores = data.result;
            updateLiveScores();
          } else {
            console.log(`HTTP error! Status: ${res.status}`);
          }
        } catch (err) {
          console.log(err);
        }
        showdiv = true;
        toggleLiveScores();
      };

      const updateLiveScores = () => {
        const hometeamlogo = livescores[0]?.home_team_logo;
        const awayteamlogo = livescores[0]?.away_team_logo;
        const result = livescores[0]?.event_final_result;
        const resultArray = result?.split(" - ");

        const firstValueText = parseInt(resultArray?.[0], 10) || "";
        const secondValueText = parseInt(resultArray?.[1], 10) || "";

        homeTeamLogo.src = hometeamlogo || "";
        awayTeamLogo.src = awayteamlogo || "";
        firstValue.textContent = firstValueText;
        secondValue.textContent = secondValueText;
      };

      const toggleLiveScores = () => {
        liveScoresDiv.style.display = showdiv && livescores.length > 0 ? "block" : "none";
        noMatches.style.display = showdiv && livescores.length === 0 ? "block" : "none";
      };

      showButton.addEventListener("click", handleClick);
    });
  </script>
</body>
</html>