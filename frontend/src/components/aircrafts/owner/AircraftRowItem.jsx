import { Button, TableCell, TableRow } from "@mui/material";
import React from "react";

const AircraftRowItem = ({ align = "left", aircraft, openModalDeleteFlight, navigate }) => {

  const onFlightEdit = () => {
    navigate(`/api/aircrafts/edit/${aircraft.id}`);
  };

  const onDelete = () => {
    openModalDeleteFlight(aircraft.id);
  };

  return <>
    <TableRow>
      <TableCell align={align}>
        {aircraft.serialNumber}
      </TableCell>
      <TableCell align={align}>
        {aircraft.model.plane}
      </TableCell>
      <TableCell align={align}>
        {aircraft.company.name}
      </TableCell>
      <TableCell align={align}>
        <Button onClick={() => onDelete()} color="error">Delete</Button>
      </TableCell>
    </TableRow>
  </>;
};

export default AircraftRowItem;