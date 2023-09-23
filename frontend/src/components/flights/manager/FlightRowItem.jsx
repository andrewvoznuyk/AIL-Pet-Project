import { Button, TableCell, TableRow } from "@mui/material";
import React from "react";

const FlightRowItem = ({ align = "left", flight, openModalFinishFlight, openModalCancelFlight }) => {

  const isFlightInPast = () => {
    const now = Date.now();
    const arrival = (Date.parse(flight.arrival));

    return arrival < now;
  };

  const onFlightCancel = () => {
    openModalCancelFlight(flight.id);
  };

  const onFlightFinish = () => {
    openModalFinishFlight(flight.id);
  };

  return <>
    <TableRow
      sx={{
        "&:last-child td, &:last-child th": { border: 0 },
        "background-color": flight.isCompleted ? "#c9c9c9" : "#fff"
      }}
    >
      <TableCell align={align}>{flight.aircraft.serialNumber}</TableCell>
      <TableCell align={align}>
        {flight.fromLocation.airport.name}, {flight.fromLocation.airport.city}, {flight.fromLocation.airport.coutry}
      </TableCell>
      <TableCell align={align}>
        {flight.toLocation.airport.name}, {flight.toLocation.airport.city}, {flight.toLocation.airport.coutry}
      </TableCell>
      <TableCell align={align}>{flight.departure}</TableCell>
      <TableCell align={align}>{flight.arrival}</TableCell>

      <TableCell align={align}>
        {
          !flight.isCompleted ? (
            <Button
              onClick={(e) => {isFlightInPast() ? onFlightFinish() : onFlightCancel();}}
              color={isFlightInPast() ? "error" : "primary"}
            >
              {isFlightInPast() ? "Finish" : "Cancel"}
            </Button>
          ) : (
            <div><Button disabled>Completed</Button></div>
          )
        }
      </TableCell>
    </TableRow>
  </>;
};

export default FlightRowItem;