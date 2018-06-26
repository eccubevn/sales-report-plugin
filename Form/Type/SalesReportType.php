<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\SalesReport\Form\Type;

use Eccube\Common\EccubeConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SalesReportType.
 */
class SalesReportType extends AbstractType
{
    /**
     * @var \Eccube\Application
     */
    private $eccubeConfig;

    /**
     * SalesReportType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * buildForm Sale Report.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $app = $this->eccubeConfig;
        // 年月の配列定義. 今年±20年
        $yearList = range(date('Y'), date('Y') - 20);
        // 1～12月
        $monthList = range(1, 12);

        $builder
            ->add('term_type', HiddenType::class, [
                'required' => false,
            ])
            ->add('monthly_year', ChoiceType::class, [
                'label' => '年',
                'required' => true,
                'choices' => array_combine($yearList, $yearList),
                'data' => date('Y'),
            ])
            ->add('monthly_month', ChoiceType::class, [
                'label' => '月',
                'required' => true,
                'choices' => array_combine($monthList, $monthList),
                'data' => date('n'),
            ])
            ->add('term_start', DateType::class, [
                'label' => '期間集計',
                'required' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
//                'empty_value' => ['year' => '----', 'month' => '--', 'day' => '--'],
                'data' => new \DateTime('first day of this month'),
            ])
            ->add('term_end', DateType::class, [
                'label' => '期間集計',
                'required' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
            ])
            ->add('unit', ChoiceType::class, [
                'label' => '集計単位',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => array_flip([
                    'byDay' => '日別',
                    'byMonth' => '月別',
                    'byWeekDay' => '曜日別',
                    'byHour' => '時間別',
                ]),
                'data' => 'byDay',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($app) {
                $form = $event->getForm();
                $data = $form->getData();
                if ($data['term_type'] === 'monthly') {
                    if (empty($data['monthly_year'])) {
                        $form['monthly_year']->addError(
                            new FormError(trans('plugin.sales_report.type.monthly.error'))
                        );
                    }
                    if (empty($data['monthly_month'])) {
                        $form['monthly_month']->addError(
                            new FormError(trans('plugin.sales_report.type.monthly.error'))
                        );
                    }
                } elseif ($data['term_type'] === 'term' && (empty($data['term_start']) || empty($data['term_end']))) {
                    $form['term_start']->addError(new FormError(trans('plugin.sales_report.type.term_start.error')));
                }
            })
        ;
    }

    /**
     * get sale report form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'sales_report';
    }
}
