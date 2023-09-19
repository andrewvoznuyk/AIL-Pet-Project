import { Paper, Table, TableBody, TableCell, TableHead, TableRow } from "@mui/material";
import FormsItem from "./FormsItem";
import { useState } from "react";

const FormsList = ({ forms }) => {
  const [disabledRows, setDisabledRows] = useState([]);

  const handleCancelClick = (index) => {
    setDisabledRows([...disabledRows, index]);
  };

  return <>
    <Paper>
      <Table>
        <TableHead>
          <TableRow>
            <TableCell>Email</TableCell>
            <TableCell>Owner fullname</TableCell>
            <TableCell>Company name</TableCell>
            <TableCell>Documents</TableCell>
            <TableCell>About</TableCell>
            <TableCell>Main airport</TableCell>
            <TableCell>Date</TableCell>
            <TableCell>Status</TableCell>
            <TableCell>Option</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {
            forms && forms.map((item, index) => (
              <FormsItem
                key={index}
                form={item}
                isDisabled={disabledRows.includes(index)}
                onCancelClick={() => handleCancelClick(index)}
              />
            ))
          }
        </TableBody>
      </Table>
    </Paper>
  </>;
};

export default FormsList;