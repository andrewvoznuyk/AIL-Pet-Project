import React, { useEffect, useState } from "react";
import {Breadcrumbs, Link, Paper, Typography} from "@mui/material";
const FlightsItem = ({flight}) => {
  return (
      <div>
          <Paper variant="outlined" style={{paddingLeft:20,margin:10,backgroundColor:"silver"}}>
              <h3>From: {flight.fromLocation.name}</h3>
              <h3>To: {flight.toLocation.name}</h3>
          </Paper>
      </div>
  );

};

export default FlightsItem;