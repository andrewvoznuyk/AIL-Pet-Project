import { Paper, Table, TableBody, TableCell, TableHead, TableRow } from "@mui/material";
import FormsItem from "./FormsItem";

const FormsList = ({ forms }) => {
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
            <TableCell>Flights from</TableCell>
            <TableCell>Flights to</TableCell>
            <TableCell>Date</TableCell>
            <TableCell>Status</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {
            forms && forms.map((item, index) => (
              <FormsItem key={index} form={item} />
            ))
          }
        </TableBody>
      </Table>
    </Paper>
  </>;
};

export default FormsList;