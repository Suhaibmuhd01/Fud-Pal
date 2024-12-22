function back() {
    const btnAction = document.getElementById("btn");
    btnAction.onclick = window.self.history.back();
}
back();