import { Button, TableCell, TableRow } from "@mui/material";
import React from "react";

const FlightRowItem = ({ align = "left", flight, openModalDeleteFlight, navigate }) => {

  const onFlightEdit = () => {
    navigate(`/api/company-flights/edit/${flight.id}`);
  };

  const onFlightDelete = () => {
    openModalDeleteFlight(flight.id);
  };

  return <>
    <TableRow>
      <TableCell align={align}>
        {flight.airport.name} ({flight.airport.city}, {flight.airport.country})
      </TableCell>
      <TableCell align={align}>
        {flight.company.name}
      </TableCell>
      <TableCell align={align}>
        <Button onClick={() => onFlightDelete()} color="error">Delete</Button>
      </TableCell>
    </TableRow>
  </>;
};

export default FlightRowItem;