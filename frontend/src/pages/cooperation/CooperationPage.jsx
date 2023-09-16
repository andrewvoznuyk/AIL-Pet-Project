import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as ClientCooperationContainer } from "../../components/cooperation/client/CooperationContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";

const CooperationPage = () => {
  const { user } = useContext(AppContext);

  return (
    <>
      <Can
        role={user.roles}
        perform={flights.USER}
        yes={() => <ClientCooperationContainer />}
      />
    </>
  );
};

export default CooperationPage;