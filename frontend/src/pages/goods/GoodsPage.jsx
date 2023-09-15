import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as AdminGoodsContainer } from "../../components/goods/admin/GoodsContainer";
import { default as ClientGoodsContainer } from "../../components/goods/client/GoodsContainer";
import { default as ManagerGoodsContainer } from "../../components/goods/manager/GoodsContainer";
import { default as OwnerGoodsContainer } from "../../components/goods/owner/GoodsContainer";
import { AppContext } from "../../App";
import { goods } from "../../rbac-consts";

const GoodsPage = () => {
  const { user } = useContext(AppContext);

  return (
    <>
      <Can
        role={user.roles}
        perform={goods.ADMIN}
        yes={() => <AdminGoodsContainer />}
      />
      <Can
        role={user.roles}
        perform={goods.USER}
        yes={() => <ClientGoodsContainer />}
      />
        <Can
            role={user.roles}
            perform={goods.MANAGER}
            yes={() => <ManagerGoodsContainer />}
        />
        <Can
            role={user.roles}
            perform={goods.OWNER}
            yes={() => <OwnerGoodsContainer />}
        />
    </>
  );
};

export default GoodsPage;