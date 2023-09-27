import { Button, Chip } from "@mui/material";
import { useEffect, useState } from "react";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";

function UserBonusesCounter () {

  const [bonuses, setBonuses] = useState(0);

  const loadUserInfo = () => {
    axios.get(`/api/username`, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setBonuses(response.data.mileBonuses);
      }
    });
  }

  useEffect(() => {
    loadUserInfo();
  }, []);

  return <>
    <Chip
      label={"Bonuses: " + bonuses}
      color="primary"
      variant="outlined"
    />
  </>
}

export default UserBonusesCounter;