import StatisticsCalculator from "../js/StatisticsCalculator.js";
let statistics;
const leaderboardTemplate = document.getElementById('leaderboard-block');
const leaderboardWrapper = document.querySelector('.leaderboard-wrapper');
let pos = 1;
const rankStyles = new Map([[1, "first"],[2, "second"],[3, "third"]]);
  
async function getLeaderboardData(){
    try{
        const response = await fetch("get-leaderboard-data.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        });
        if(!response.ok){
            throw new error(`Response status ${response.status}`);
        }
        const json_data = await response.json()
        statistics = new StatisticsCalculator(json_data);
        statistics.processLeaderboardData();
        statistics.leaderboard_data.forEach((value,key)=>{
            const leaderboardBlock = document.importNode(leaderboardTemplate,true).content;
            leaderboardBlock.querySelector('.rank').textContent = pos;
            leaderboardBlock.querySelector('.name').textContent = value.name;
            leaderboardBlock.querySelector('.streak').textContent = value.streak;
            leaderboardBlock.querySelector('.on-time').textContent = Math.round(((value.onTime/value.classes)*10000))/100 +"%";
            leaderboardBlock.querySelector('.attendance').textContent = Math.round(((value.attendance/value.classes)*10000))/100+"%";
            if(rankStyles.has(pos)){
                leaderboardBlock.querySelector('.leaderboard-content').classList.add(rankStyles.get(pos));
            }
            pos+=1;
            leaderboardWrapper.appendChild(leaderboardBlock);
        });
    }
    catch(error){
        console.error(error.message);
    }
}
getLeaderboardData()