import jQuery from "jquery";
import ky from "ky";
import Popper from "popper.js";

window.Popper = Popper;
window.$ = window.jQuery = jQuery;

require("bootstrap");

const headers = {
  "x-requested-with": "XMLHttpRequest",
};

const meta = document.querySelector(`meta[name="csrf-token"]`);
if (meta) {
  headers["x-csrf-token"] = meta.content;
}

window.ky = ky.create({ headers });
