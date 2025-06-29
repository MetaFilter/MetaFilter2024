declare(strict_types=1);

namespace App\Livewire\Contact;

use App\Http\Requests\Contact\StoreContactMessageRequest;
use Livewire\Form;

final class ContactMessageForm extends Form
{
    protected function rules(): array
    {
        return (new StoreContactMessageRequest())->rules();
    }
}
