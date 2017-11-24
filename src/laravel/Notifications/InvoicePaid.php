<?php

namespace Dev7studios\Chip\Laravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;

class InvoicePaid extends Notification
{
    use Queueable;

    /**
     * @var \Laravel\Cashier\Billable
     */
    public $user;
    
    /**
     * @var \Laravel\Cashier\Invoice
     */
    public $invoice;

    /**
     * Create a new notification instance.
     *
     * @param \Laravel\Cashier\Billable $user
     * @param \Laravel\Cashier\Invoice  $invoice
     */
    public function __construct($user, $invoice)
    {
        $this->user    = $user;
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = config('app.name');
        $pdf     = $this->pdf([
            'user'           => $this->user,
            'invoice'        => $this->invoice,
            'vendor'         => $appName,
            'companyAddress' => config('chip.billing_address', []),
        ]);

        return (new MailMessage)
                    ->subject($appName . ' Invoice')
                    ->line('Thanks for supporting ' . $appName . '. You\'ll find an invoice attached.')
                    ->attachData($pdf, 'invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Capture the invoice as a PDF and return the raw bytes.
     *
     * @param  array  $data
     * @return string
     */
    protected function pdf($data = [])
    {
        if (!defined('DOMPDF_ENABLE_AUTOLOAD')) {
            define('DOMPDF_ENABLE_AUTOLOAD', false);
        }

        if (file_exists($configPath = base_path().'/vendor/dompdf/dompdf/dompdf_config.inc.php')) {
            require_once $configPath;
        }

        $view = View::make('chip::invoice', $data);

        $dompdf = new \Dompdf\Dompdf;
        $dompdf->loadHtml($view->render());
        $dompdf->render();

        return $dompdf->output();
    }
}
