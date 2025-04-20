import './bootstrap';

import Clipboard from '@ryangjchandler/alpine-clipboard';
import Precognition from 'laravel-precognition-alpine';

import {closeDropdown, toggleDropdowns} from './modules/toggleDropdowns.js';
import {toggleTheme} from './modules/toggleTheme.js';

window.Alpine = Alpine;

Alpine.plugin([
    Clipboard,
    Precognition
]);

toggleDropdowns();
toggleTheme();

document.addEventListener('click', event => {
    let eventTarget = event.target;
/*
    if (event.key === 'Escape'){
        //do something here
        Livewire.dispatch('escape-key-clicked');
    }
*/
    if (!eventTarget.closest('.global-navigation-menu')) {
//        closeDropdown('global-navigation-dropdown-toggle');
    }
}, false);

document.addEventListener('livewire:init', () => {
    Livewire.on('onkeydown', (event) => {
        if (event.key === 'Escape') {
            Livewire.dispatch('escape-key-clicked', false);
        }
    });
});

/*
function keyPress (e)(){
document.addEventListener("keyup", keyPress);
    <script>
        document.onkeydown = function(event) {
            if (event.key === 'Escape') {
                window.livewire.emit('cancelReplying');
            }
        };
    </script>

document.addEventListener('click', function (event) {
    if (!event.target.closest('.some-selector')) {
        // Clicked outside the element...
    }
}, false);
      click on dropdown toggle
      add id of dropdown to list of open dropdowns
      add event listener to document
        if click is outside of dropdown
          remove id of dropdown from list of open dropdowns



    let globalNavigationExpanded = getExpanded(globalNavigationToggle);
    let utilityNavigationExpanded = false;

    if (utilityNavigationToggle !== null) {
        utilityNavigationExpanded = getExpanded(utilityNavigationToggle);
    }
    if (eventTarget === darkModeToggle) {
        toggleDarkMode(eventTarget);
    }

    do {
        if (eventTarget === globalNavigationToggle || eventTarget === utilityNavigationToggle) {
            console.log('Clicked inside!');
            toggleDropdown(eventTarget);
        }

        eventTarget = eventTarget.parentNode;
    } while (eventTarget);

    if (globalNavigationExpanded) {
        toggleDropdown(globalNavigationToggle);
    }

    if (utilityNavigationExpanded) {
        toggleDropdown(utilityNavigationToggle);
    }
*/

//    console.log('Clicked outside!');
