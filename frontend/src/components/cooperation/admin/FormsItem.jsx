import { Button, TableCell, TableRow } from "@mui/material";
import React, { useState } from "react";
import updateFormData from "../../../utils/updateFormData";

const FormsItem = ({ form, isDisabled, onCancelClick, updateFormStatus }) => {
  const [isRegistered, setIsRegistered] = useState(false);

  const handleRegisterClick = () => {
    updateFormData(form["@id"], { status: 'registered' });
    setIsRegistered(true);
  };

  return <>
    <TableRow className={isDisabled ? "disabled-row" : ""}>
      <TableCell>{form.email}</TableCell>
      <TableCell>{form.fullname}</TableCell>
      <TableCell>{form.companyName}</TableCell>
      <TableCell>{form.documents}</TableCell>
      <TableCell>{form.about}</TableCell>
      <TableCell>{form.airport}</TableCell>
      <TableCell>{form.dateOfApplication}</TableCell>
      <TableCell>{form.status}</TableCell>
      <TableCell>
        {form.status === 'registered' ? (
          <span style={{ color: 'green' }}>Registered</span>
        ) : (
          <>
            {isRegistered ? (
              <span style={{ color: 'green' }}>Registered</span>
            ) : (
              <Button
                onClick={handleRegisterClick}
                disabled={isRegistered || isDisabled}
              >
                Register
              </Button>
            )}
            {!isDisabled && (
              <Button onClick={() => onCancelClick(form)} disabled={isDisabled}>
                Cancel
              </Button>
            )}
          </>
        )}
      </TableCell>
    </TableRow>
  </>;
};

export default FormsItem;