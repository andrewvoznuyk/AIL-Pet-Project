import { TextField } from "@mui/material";
import React from "react";

const InputCustom = ({
  id = undefined, label = "",
  type = "", name = "",
  required = false, endAdornment = null
}) => {

  return (
    <TextField
      variant="standard"
      id={id}
      type={type}
      label={label}
      name={name}
      required={required}
      endAdornment={endAdornment}
    />
  );
};

export default InputCustom;