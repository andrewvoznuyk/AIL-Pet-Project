import { TableCell, TableRow } from "@mui/material";
import React, { useEffect, useState } from "react";

function TableItem ({ticket, key}) {

  return <>
    <TableRow key={key}>
      <TableCell>{`${ticket.flight.fromLocation.airport.name} - ${ticket.flight.toLocation.airport.name}`}</TableCell>
      <TableCell>{`${ticket.name} ${ticket.surname}`}</TableCell>
      <TableCell>{ticket.flight.departure}</TableCell>
      <TableCell>{ticket.flight.arrival}</TableCell>
      <TableCell>{ticket.place}</TableCell>
      <TableCell>{ticket.class}</TableCell>
    </TableRow>
  </>
}

export default TableItem;