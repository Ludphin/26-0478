<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Study Planner</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
}

header{
    background:#4CAF50;
    color:white;
    text-align:center;
    padding:20px;
}

nav{
    background:#333;
    padding:10px;
    text-align:center;
}

nav a{
    color:white;
    text-decoration:none;
    margin:15px;
    font-weight:bold;
}

.hero{
    text-align:center;
    padding:50px;
    background:white;
}

.hero h2{
    color:#4CAF50;
    margin-bottom:10px;
}

.section{
    padding:30px;
}

.cards{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
}

.card{
    background:white;
    width:250px;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.2);
    text-align:center;
}

.card h3{
    color:#4CAF50;
}

.planner{
    text-align:center;
    margin-top:30px;
}

input{
    padding:10px;
    width:250px;
}

button{
    padding:10px 15px;
    background:#4CAF50;
    color:white;
    border:none;
    cursor:pointer;
}

ul{
    list-style:none;
    margin-top:20px;
}

li{
    background:white;
    padding:10px;
    margin:10px auto;
    width:300px;
    border-radius:5px;
}

footer{
    background:#333;
    color:white;
    text-align:center;
    padding:15px;
    margin-top:30px;
}
</style>
</head>

<body>

<header>
    <h1>📚 Smart Study Planner</h1>
    <p>Plan Your Studies and Achieve Your Goals</p>
</header>

<nav>
    <a href="#">Home</a>
    <a href="#">Subjects</a>
    <a href="#">Schedule</a>
    <a href="#">Contact</a>
</nav>

<section class="hero">
    <h2>Welcome to Your Study Planner</h2>
    <p>Organize assignments, exams, and study sessions easily.</p>
</section>

<section class="section">
    <div class="cards">
        <div class="card">
            <h3>📝 Assignments</h3>
            <p>Track all your assignments and deadlines.</p>
        </div>

        <div class="card">
            <h3>📅 Timetable</h3>
            <p>Create a weekly study schedule.</p>
        </div>

        <div class="card">
            <h3>🎯 Goals</h3>
            <p>Set study goals and monitor progress.</p>
        </div>
    </div>

    <div class="planner">
        <h2>Add Study Task</h2><br>

        <input type="text" id="taskInput" placeholder="Enter study task">
        <button onclick="addTask()">Add Task</button>

        <ul id="taskList"></ul>
    </div>
</section>

<footer>
    <p>&copy; 2026 Smart Study Planner | Designed by Abigael</p>
</footer>

<script>
function addTask(){
    let taskInput = document.getElementById("taskInput");
    let task = taskInput.value;

    if(task !== ""){
        let li = document.createElement("li");
        li.textContent = task;

        document.getElementById("taskList").appendChild(li);

        taskInput.value = "";
    }
}
</script>

</body>
</html>
    
