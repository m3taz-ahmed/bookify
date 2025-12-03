<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'type' => Page::TYPE_ABOUT_US,
                'slug' => 'about-us',
                'title_en' => 'About Us',
                'title_ar' => 'معلومات عنا',
                'content_en' => '<h1>About Our Company</h1><p>Welcome to our booking system. We provide excellent services to meet all your needs.</p>',
                'content_ar' => '<h1>عن شركتنا</h1><p>مرحبا بكم في نظام الحجز لدينا. نحن نقدم خدمات ممتازة لتلبية جميع احتياجاتكم.</p>',
                'company_name_en' => 'SkyBridge Solutions',
                'company_name_ar' => 'حلول سكاي بريدج',
                'founded_year' => 2020,
                'location_en' => 'Riyadh, Saudi Arabia',
                'location_ar' => 'الرياض، المملكة العربية السعودية',
                'company_description_en' => '<p>SkyBridge Solutions is a leading provider of innovative booking solutions for businesses of all sizes.</p>',
                'company_description_ar' => '<p>حلول سكاي بريدج هي شركة رائدة في تقديم حلول الحجز المبتكرة للشركات من جميع الأحجام.</p>',
                'history_en' => '<p>Founded in 2020, we have grown to become one of the most trusted booking platforms in the region.</p>',
                'history_ar' => '<p>تأسست في عام 2020، وقد نمت لتصبح واحدة من أكثر منصات الحجز ثقة في المنطقة.</p>',
                'is_active' => true,
            ],
            [
                'type' => Page::TYPE_CONTACT_US,
                'slug' => 'contact-us',
                'title_en' => 'Contact Us',
                'title_ar' => 'اتصل بنا',
                'content_en' => '<h1>Contact Information</h1><p>Email: info@example.com</p><p>Phone: +1234567890</p>',
                'content_ar' => '<h1>معلومات الاتصال</h1><p>البريد الإلكتروني: info@example.com</p><p>الهاتف: +1234567890</p>',
                'email' => 'info@skybridge.com',
                'phone' => '+966 11 123 4567',
                'whatsapp' => '+966 55 123 4567',
                'address_en' => 'SkyBridge Tower, Riyadh, Saudi Arabia',
                'address_ar' => 'برج سكاي بريدج، الرياض، المملكة العربية السعودية',
                'latitude' => 24.7136,
                'longitude' => 46.6753,
                'map_zoom' => 15,
                'contact_description_en' => '<p>We\'re here to help you with any questions or concerns you may have.</p>',
                'contact_description_ar' => '<p>نحن هنا لمساعدتكم بأي أسئلة أو استفسارات قد تكون لديكم.</p>',
                'is_active' => true,
            ],
            [
                'type' => Page::TYPE_TERMS_CONDITIONS,
                'slug' => 'terms-and-conditions',
                'title_en' => 'Terms and Conditions',
                'title_ar' => 'الشروط والأحكام',
                'content_en' => '<h1>Terms and Conditions</h1><p>Please read these terms and conditions carefully before using our services.</p>',
                'content_ar' => '<h1>الشروط والأحكام</h1><p>يرجى قراءة هذه الشروط والأحكام بعناية قبل استخدام خدماتنا.</p>',
                'is_active' => true,
            ],
            [
                'type' => Page::TYPE_PRIVACY_POLICY,
                'slug' => 'privacy-policy',
                'title_en' => 'Privacy Policy',
                'title_ar' => 'سياسة الخصوصية',
                'content_en' => '<h1>Privacy Policy</h1><p>We are committed to protecting your privacy and personal information.</p>',
                'content_ar' => '<h1>سياسة الخصوصية</h1><p>نحن ملتزمون بحماية خصوصيتكم ومعلوماتكم الشخصية.</p>',
                'is_active' => true,
            ],
            [
                'type' => Page::TYPE_FAQ,
                'slug' => 'faq',
                'title_en' => 'Frequently Asked Questions',
                'title_ar' => 'الأسئلة الشائعة',
                'content_en' => '<h1>Frequently Asked Questions</h1><p><strong>Q: How do I book a service?</strong></p><p>A: You can book a service by selecting the service you want and following the booking process.</p>',
                'content_ar' => '<h1>الأسئلة الشائعة</h1><p><strong>س: كيف يمكنني حجز خدمة؟</strong></p><p>ج: يمكنك حجز خدمة عن طريق اختيار الخدمة التي تريدها واتباع عملية الحجز.</p>',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}