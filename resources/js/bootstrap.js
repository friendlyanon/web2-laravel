import jQuery from "jquery";
import ky from "ky";
import Popper from "popper.js";

window.Popper = Popper;
window.$ = window.jQuery = jQuery;

require("bootstrap");

window.ky = ky.create({
  headers: {
    "x-requested-with": "XMLHttpRequest",
  },
});
