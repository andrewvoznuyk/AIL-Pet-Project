import React from "react";
import { Modal, Button } from "@mui/material";

const ModalConfirmEmail = ({ open, onClose, onConfirm, onNotMyEmail }) => {
  return (
    <Modal open={open} onClose={onClose}>
      <div className="modal-container">
        <div className="modal-content">
          <h2>Confirm Email</h2>
          <Button variant="contained" color="primary" onClick={onConfirm}>
            Confirm
          </Button>
          <Button variant="contained" color="inherit" onClick={onNotMyEmail}>
            Not my email
          </Button>
        </div>
      </div>
    </Modal>
  );
};

export default ModalConfirmEmail;