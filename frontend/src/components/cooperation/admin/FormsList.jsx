import {
  Button, Dialog, DialogActions, DialogContent, DialogTitle,
  Paper,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow
} from "@mui/material";
import FormsItem from "./FormsItem";
import { useState } from "react";
import WorkerRegistrationForm from "../../registration/WorkerRegistrationForm";
import updateFormData from "../../../utils/updateFormData";

const FormsList = ({ forms }) => {
  const [disabledRows, setDisabledRows] = useState([]);
  const [showRegisterForm, setShowRegisterForm] = useState(false);

  const handleCancelClick = (index) => {
    setDisabledRows([...disabledRows, index]);
  };

  const openRegisterForm = () => {
    setShowRegisterForm(true);
  };

  const closeRegisterForm = () => {
    setShowRegisterForm(false);
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
                openRegisterForm={openRegisterForm}
              />
            ))
          }
        </TableBody>
      </Table>
    </Paper>

    {showRegisterForm && (
      <Dialog open={showRegisterForm} onClose={closeRegisterForm}>
        <DialogTitle>Register Form</DialogTitle>
        <DialogContent>
          <WorkerRegistrationForm />
        </DialogContent>
        <DialogActions>
          <Button onClick={closeRegisterForm} color="primary">
            X
          </Button>
        </DialogActions>
      </Dialog>
    )}
  </>;
};

export default FormsList;