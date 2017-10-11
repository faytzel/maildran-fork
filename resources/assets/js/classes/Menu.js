class Menu
{
    constructor()
    {
        var self = this;

        $(document).ready(function()
        {
            self.onLoad();
        });
    }

    onLoad()
    {
        $('body').on('click', '#header-menu-btn a, #header-menu-btn-close', function(event) {
            if ($('#header-menu-submenu').is(':hidden')) {
                $('#header-menu-submenu').show();
            } else {
                $('#header-menu-submenu').hide();
            }
        });
    }
}

export default Menu;
window.MenuClass = Menu;
