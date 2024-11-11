import {Plugins, Swappable} from "@shopify/draggable";
import Alerts from "../alerts.js";
function Flexbox() {
    const containers = document.querySelectorAll('#orderable .draggable');

    if (containers.length === 0) {
        return false;
    }

    const swappable = new Swappable(containers, {
        draggable: '.is_draggable',
        mirror: {
            constrainDimensions: true,
        },
        plugins: [Plugins.ResizeMirror],
    });

    return swappable;
}

Flexbox()

const button = document.querySelector('[data-action-post]')
if( button )
{
    button.addEventListener('click', e => {
        e.preventDefault()

        let order           = []
        $('.draggable').each((i, el)=>{
            order.push({ id: $(el).attr('data-id'), position: i })
        })

        axios.post(url_route, {order: order}).then(({status, data})=>{
          if( data.success )
          {
              Alerts.success_callback('Se reordenaron los registros correctamente.', 'Actualización exitosa', O => { location.href = url_route_back } )
          }
          else
          {
              Alerts.error('Lo sentimos, no fue posible ordenar los registros en este momento.')
          }
        })
            .catch(error => console.error(error))
            .finally()
    })
}
