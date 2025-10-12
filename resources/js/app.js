import './bootstrap';


// Disable this alpine to avoid any duplicate loading together with alpine from livewire
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
