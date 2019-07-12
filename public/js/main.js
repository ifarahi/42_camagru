var d = 0;
function displaymenu()
{
    if(d == 0)
    {
        document.getElementById("navbarsExampleDefault").style.display = "block";
        d = 1;
    }else
    {
        document.getElementById("navbarsExampleDefault").style.display = "none";
        d = 0;
    }
}