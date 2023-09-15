import * as React from "react";
import MenuItem from "@mui/material/MenuItem";
import eventBus from "../../../../utils/eventBus";

export default function DropdownUnlogged ({goTo}) {

  return (
    <>
      <MenuItem onClick={() => goTo("login")}>Sign in</MenuItem>
      <MenuItem onClick={() => goTo("register")}>Sign up</MenuItem>
    </>
  )
    ;
}