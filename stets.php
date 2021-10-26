<?php
  if (extension_loaded('sockets')) {
      ErrLog("WebSockets OK") ;
} else {
    ErrLog("WebSockets UNAVAILABLE");
}