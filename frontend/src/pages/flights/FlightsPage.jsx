import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as OwnerFlightsContainer } from "../../components/flights/owner/FlightsContainer";
import { default as ManagerFlightsContainer } from "../../components/flights/manager/FlightsContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";
import NotFoundPage from "../notFound/NotFoundPage";

const FlightsPage = () => {
  const { user } = useContext(AppContext);

  if(!user){
    return <NotFoundPage />
  }

  return (
    <>
      <Can
        role={user.roles}
        perform={flights.OWNER}
        yes={() => <OwnerFlightsContainer />}
      />
      <Can
        role={user.roles}
        perform={flights.MANAGER}
        yes={() => <ManagerFlightsContainer />}
      />
    </>
  );
};

export default FlightsPage;