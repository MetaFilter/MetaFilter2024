<?php

declare(strict_types=1);

namespace App\Livewire\Wizards;

use App\Dtos\UserDto;
use App\Enums\UserStateEnum;
use App\Http\Requests\Auth\StorePasswordRequest;
use App\Http\Requests\Signup\StoreEmailAddressRequest;
use App\Http\Requests\Signup\StoreUsernameRequest;
use App\Jobs\SendVerificationEmail;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserService;
use App\Traits\LoggingTrait;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

final class SignupWizardComponent extends BaseWizardComponent
{
    use LoggingTrait;

    public string $username;
    public string $password;
    public string $password_confirmation;
    public string $email;
    public string $name;
    public string $state;

    public array $steps = [
        'Username',
        'Password',
        'Email Address',
        'Payment',
    ];

    protected User $user;
    protected ?int $userId = null;
    protected UserRepositoryInterface $userRepository;
    protected UserService $userService;

    public function boot(
        UserRepositoryInterface $userRepository,
        UserService $userService,
    ): void {
        $this->user = new User();
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function render(): View
    {
        return view('livewire.wizards.signup.signup-wizard-component');
    }

    // Step 1
    public function submitUsername(): void
    {
        $rules = (new StoreUsernameRequest())->rules();

        $this->validate($rules);
        \Log::debug('Username: ' . $this->username);
        $this->currentStep = 2;
    }

    // Step 2
    public function submitPassword(): void
    {
        $rules = (new StorePasswordRequest())->rules();
        \Log::debug('Password: ' . $this->password);

        $this->validate($rules);

        $this->currentStep = 3;
    }

    // Step 3
    public function submitEmailAddress(): void
    {
        $this->email = strtolower($this->email);
        $rules = (new StoreEmailAddressRequest())->rules();
        \Log::debug('Email: ' . $this->email);

        $this->validate($rules);

        $state = UserStateEnum::Pending->value;

        $this->user = $this->store($state);
        \Log::debug('This user ID: ' . $this->user->id);
        $this->userId = $this->user->id;
        $this->currentStep = 4;
    }

    // Step 4
    public function payWithPayPal(): void
    {
        $this->paymentSubmitted();
    }

    public function payWithStripe(): void
    {
        $this->paymentSubmitted();
    }

    private function paymentSubmitted(): void
    {
        // Assuming successful payment
        $user = User::where('username', '=', $this->username)->first();
        $user->state = UserStateEnum::Active->value;
        $user->save();

        SendVerificationEmail::dispatch($user);

        Auth::login($user);

        $this->redirectRoute('signup.thanks');
    }

    public function store(string $state): ?User
    {
        try {
            $dto = new UserDto(
                username: $this->username,
                password: bcrypt($this->password),
                email: $this->email,
                name: $this->name ?? null,
                state: $state,
            );

            return $this->userRepository->createUser($dto);
        } catch (Exception $exception) {
            $this->logError($exception);

            return null;
        }
    }
}
