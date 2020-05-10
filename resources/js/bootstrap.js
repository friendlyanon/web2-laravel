import jQuery from "jquery";
import ky, { NormalizedOptions } from "ky";
import Popper from "popper.js";

window.Popper = Popper;
window.$ = window.jQuery = jQuery;

require("bootstrap");

/**
 * @param {Request} request
 * @param {NormalizedOptions} options
 */
function addCsrfForSameOrigin(request, options) {
  const { protocol, host } = new URL(request.url);
  const { location } = window;
  if (location.host !== host || location.protocol !== protocol) {
    return;
  }

  /** @type {HTMLMetaElement|null} */
  const meta = document.querySelector(`meta[name="csrf-token"]`);
  if (meta != null) {
    request.headers.set("x-csrf-token", meta.content);
  }
}

window.ky = ky.create({
  headers: {
    "x-requested-with": "XMLHttpRequest",
  },
  hooks: {
    beforeRequest: [addCsrfForSameOrigin],
  }
});
