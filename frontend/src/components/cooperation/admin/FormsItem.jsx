import { Button, TableCell, TableRow } from "@mui/material";
import React, { useState } from "react";
import updateFormData from "../../../utils/updateFormData";

const FormsItem = ({ form, isDisabled, onCancelClick, openRegisterForm }) => {
  const [isRegistered, setIsRegistered] = useState(false);

  const handleRegisterClick = () => {
    updateFormData(form["@id"], { status: "registered" });
    setIsRegistered(true);

    openRegisterForm();
  };

  const handleCancelClick = () => {
    updateFormData(form["@id"], { status: "canceled" });
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
        {form.status === "registered" ? (
          <span style={{ color: "green" }}>Registered</span>
        ) : (
          <>
            {isRegistered ? (
              <span style={{ color: "green" }}>Registered</span>
            ) : (!isDisabled && form.status !== "canceled" &&
              <Button
                onClick={handleRegisterClick}
                disabled={isRegistered || isDisabled}
              >
                Register
              </Button>
            )}
            {form.status === "canceled" ? (
              <span style={{ color: "grey" }}>Canceled</span>
            ) : (!isRegistered &&
              <Button
                onClick={() => {
                  onCancelClick(form);
                  handleCancelClick();
                }} disabled={isDisabled}
              >
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