// Simulating useState and useEffect functionality
let showdiv = false;
let livescores = [];
let hometeamlogo = '';
let awayteamlogo = '';
let firstValue = 0;
let secondValue = 0;

function useState(initialValue) {
  let state = initialValue;
  const getState = () => state;
  const setState = (newValue) => {
    state = newValue;
    render();
  };
  return [getState(), setState];
}

function useEffect(callback, dependencies) {
  callback();
}

function render() {
  const appDiv = document.getElementById('app');

  const handleClick = async () => {
    try {
      const apiKey = "5f4b42c1d5ac703c0ed3596590d0bb70d8962f1e06a1d8990b29a6d5bd72c9e1"; // Replace with your actual API key
      const res = await fetch(`https://apiv2.allsportsapi.com/football/?met=Livescore&APIkey=${apiKey}`);
      
      if (res.ok) {
        const data = await res.json();
        console.log(data);
        livescores = data.result || [];
        hometeamlogo = livescores[0]?.home_team_logo || '';
        awayteamlogo = livescores[0]?.away_team_logo || '';
        const result = livescores[0]?.event_final_result;
        const resultArray = result?.split(" - ");
        firstValue = parseInt(resultArray?.[0], 10) || 0;
        secondValue = parseInt(resultArray?.[1], 10) || 0;
      } else {
        console.log(`HTTP error! Status: ${res.status}`);
      }
    } catch (err) {
      console.log(err);
    }
    showdiv = true;
    render();
  };

  const button = document.createElement('button');
  button.textContent = 'Show live score';
  button.addEventListener('click', handleClick);

  const div = document.createElement('div');
  div.classList.add('App');

  if (showdiv) {
    if (livescores.length > 0) {
      const flexContainer = document.createElement('div');
      flexContainer.classList.add('flex', 'container');

      const homeTeamDiv = document.createElement('div');
      const homeTeamImage = document.createElement('img');
      homeTeamImage.src = hometeamlogo;
      const homeTeamScore = document.createElement('h2');
      homeTeamScore.textContent = firstValue;
      homeTeamDiv.appendChild(homeTeamImage);
      homeTeamDiv.appendChild(homeTeamScore);

      const vsDiv = document.createElement('div');
      vsDiv.style.fontWeight = 'bold';
      vsDiv.style.fontSize = '4rem';
      vsDiv.style.textAlign = 'center';
      vsDiv.textContent = 'vs';

      const awayTeamDiv = document.createElement('div');
      const awayTeamImage = document.createElement('img');
      awayTeamImage.src = awayteamlogo;
      const awayTeamScore = document.createElement('h2');
      awayTeamScore.textContent = secondValue;
      awayTeamDiv.appendChild(awayTeamImage);
      awayTeamDiv.appendChild(awayTeamScore);

      flexContainer.appendChild(homeTeamDiv);
      flexContainer.appendChild(vsDiv);
      flexContainer.appendChild(awayTeamDiv);
      div.appendChild(flexContainer);
    } else {
      const noLiveMatches = document.createElement('h1');
      noLiveMatches.textContent = 'No Live Matches Currently';
      div.appendChild(noLiveMatches);
    }
  }

  while (appDiv.firstChild) {
    appDiv.removeChild(appDiv.firstChild);
  }

  div.appendChild(button);
  appDiv.appendChild(div);
}

function App() {}

useEffect(() => {
  render();
}, []);

App();
