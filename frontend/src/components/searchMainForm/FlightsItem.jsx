import React, { useEffect, useState } from "react";
import {Breadcrumbs, Button, Card, CardActions, CardContent, CardMedia, Link, Paper, Typography} from "@mui/material";
const FlightsItem = ({flight}) => {
  return (
      <Card sx={{ maxWidth: 1600 }} style={{border:2,borderStyle:"solid", color:"black", margin:10, marginTop:30,backgroundColor:"azure"}}>
          <CardContent>
              <Typography gutterBottom variant="h5" component="div">
                  From: {flight.fromLocation.name}
              </Typography>
              <Typography gutterBottom variant="h5" component="div">
                  To: {flight.toLocation.name}
              </Typography>
              <Typography variant="body2" color="black">
                  Distance: {flight.distance} km
              </Typography>
              <Typography variant="body2" color="black">
                  Model: {flight.aircraftModel}
              </Typography>
              <Typography variant="body2" color="black">
                  Number: {flight.aircraftNumber}
              </Typography>
          </CardContent>
          <CardActions>
              <Button style={{color:"white",backgroundColor:"black",padding:10}}>Buy ticket now!</Button>
          </CardActions>
      </Card>
  );

};

export default FlightsItem;