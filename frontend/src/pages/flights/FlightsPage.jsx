import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as OwnerFlightsContainer } from "../../components/flights/owner/FlightsContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";

const FlightsPage = () => {
  const { user } = useContext(AppContext);

  return (
    <>
      <Can
        role={user.roles}
        perform={flights.OWNER}
        yes={() => <OwnerFlightsContainer />}
      />
    </>
  );
};

export default FlightsPage;