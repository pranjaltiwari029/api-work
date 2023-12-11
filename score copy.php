<!DOCTYPE html>
<html>
<head>
  <title>Live Scores</title>
  <style>
    .flex {
      display: flex;
      justify-content: space-around;
      align-items: center;
    }
  </style>
</head>
<body>
  <div class="App">
    <button id="showButton">Show live score</button>
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