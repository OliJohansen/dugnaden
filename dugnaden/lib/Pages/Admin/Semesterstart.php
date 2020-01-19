<?php

namespace Blindern\Dugnaden\Pages\Admin;

class Semesterstart extends BaseAdmin
{
    function show()
    {
        $this->page->addNavigation("Innstillinger", "index.php?do=admin&admin=Innstillinger");
        $this->page->addNavigation("Semesterstart", "index.php?do=admin&admin=Semesterstart");

        $page = get_layout_parts("menu_semesterstart");

        if (truncateAllowed() == false) {
            // $page["disable_kalender"] = "disabled='disabled'" . $page["disable_kalender"];
            $page["disable_import"] = "disabled='disabled'" . $page["disable_import"];
            $page["disable_tildele"] = "disabled='disabled'" . $page["disable_tildele"];
        }

        $this->page->addContentHtml(implode($page));
    }
}
