import React, { useEffect, useState } from "react";
import {Breadcrumbs, Link, Paper, Typography} from "@mui/material";
const FlightsItem = ({flight}) => {
  return (
      <div>
          <Paper variant="outlined" style={{paddingLeft:20,margin:10,backgroundColor:"silver"}}>
              <h3>Name: {flight.id}</h3>

          </Paper>
      </div>
  );

};

export default FlightsItem;