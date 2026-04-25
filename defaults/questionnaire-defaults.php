<?php
/**
 * Default content for the Interactive Questionnaire widget.
 *
 * 'questions'    – each entry needs 'question_text' and 'result_mappings'
 *                  (result_mappings must match a result_id below)
 * 'result_types' – each entry needs 'result_id' and 'result_title'
 */
return [

    'questions' => [
        [ 'question_text' => 'Ich brauche einen klaren Plan bevor ich mich wohlf&uuml;hle.',                                    'result_mappings' => 'plan'         ],
        [ 'question_text' => 'Ich habe das Gef&uuml;hl, dass ich immer 110% geben muss, damit es gut genug ist.',               'result_mappings' => 'perfekt'      ],
        [ 'question_text' => 'Ich bem&uuml;he mich, es allen recht zu machen, damit niemand entt&auml;uscht ist.',              'result_mappings' => 'harmonie'     ],
        [ 'question_text' => 'Wenn etwas schwierig wird, ziehe ich es durch - auch wenn es mich viel Kraft kostet.',            'result_mappings' => 'kampf'        ],
        [ 'question_text' => 'Ich verlasse mich ungern auf andere, weil ich lieber alles selbst in die Hand nehme.',            'result_mappings' => 'unabhaengig'  ],
        [ 'question_text' => 'Fehler in meiner Arbeit kann ich kaum akzeptieren.',                                              'result_mappings' => 'perfekt'      ],
        [ 'question_text' => '&Uuml;berraschungen oder ungeplante Ereignisse st&ouml;ren mich stark.',                          'result_mappings' => 'plan'         ],
        [ 'question_text' => 'Mir ist es wichtig, alles meine Probleme alleine zu l&ouml;sen.',                                 'result_mappings' => 'unabhaengig'  ],
        [ 'question_text' => 'Ich f&uuml;hle mich schuldig, wenn ich bei einer Aufgabe aufgebe.',                               'result_mappings' => 'kampf'        ],
        [ 'question_text' => 'Es macht mich unruhig, wenn jemand b&ouml;se auf mich ist.',                                      'result_mappings' => 'harmonie'     ],
        [ 'question_text' => 'Ich &uuml;berarbeite meine Aufgaben h&auml;ufig, selbst wenn sie schon "fertig" sind.',           'result_mappings' => 'perfekt'      ],
        [ 'question_text' => '"Augen zu und durch" ist oft meine Devise.',                                                      'result_mappings' => 'kampf'        ],
        [ 'question_text' => 'Es f&auml;llt mir schwer, unordentliche oder ungenaue Arbeit anderer zu akzeptieren.',            'result_mappings' => 'perfekt'      ],
        [ 'question_text' => 'Ich stelle oft meine Bed&uuml;rfnisse hinten an, um andere zufriedenzustellen.',                  'result_mappings' => 'harmonie'     ],
        [ 'question_text' => 'Ich achte darauf, dass alles nach meinen Vorstellungen abl&auml;uft.',                            'result_mappings' => 'plan'         ],
        [ 'question_text' => 'Hilfe von anderen anzunehmen, f&uuml;hlt sich wie ein Versagen an.',                              'result_mappings' => 'unabhaengig'  ],
        [ 'question_text' => 'Es f&auml;llt mir schwer, mir selbst Pausen zu erlauben.',                                        'result_mappings' => 'kampf'        ],
        [ 'question_text' => 'Ich frage mich oft, ob ich genug tue, um von anderen gemocht zu werden.',                         'result_mappings' => 'harmonie'     ],
        [ 'question_text' => 'Ich habe Angst, weniger respektiert zu werden, wenn ich nicht alles perfekt mache.',              'result_mappings' => 'perfekt'      ],
        [ 'question_text' => 'Es f&auml;llt mir schwer, Entscheidungen abzugeben, die mich betreffen.',                         'result_mappings' => 'unabhaengig'  ],
        [ 'question_text' => 'Es f&auml;llt mir schwer, Aufgaben zu deligieren, weil ich sicher sein will, dass alles stimmt.', 'result_mappings' => 'plan'         ],
        [ 'question_text' => 'Ich glaube, dass Anstregung immer der Schl&uuml;ssel zum Erfolg ist.',                            'result_mappings' => 'kampf'        ],
        [ 'question_text' => 'Ich habe Angst davor, von anderen abh&auml;ngig zu sein.',                                        'result_mappings' => 'unabhaengig'  ],
        [ 'question_text' => 'Kritik von anderen trifft mich sehr und besh&auml;ftigt mich lange.',                             'result_mappings' => 'harmonie'     ],
        [ 'question_text' => 'Es macht mich unruhig, wenn ich nicht wei&szlig;, was als n&auml;chstes passiert.',               'result_mappings' => 'plan'         ],
    ],

    'result_types' => [
        [ 'result_id' => 'perfekt',     'result_title' => 'Die innere Stimme der Perfektionistin'   ],
        [ 'result_id' => 'harmonie',    'result_title' => 'Die innere Stimme der Harmonie-Sucherin' ],
        [ 'result_id' => 'kampf',       'result_title' => 'Die innere Stimme der K&auml;mpferin'    ],
        [ 'result_id' => 'plan',        'result_title' => 'Die innere Stimme der Planerin'          ],
        [ 'result_id' => 'unabhaengig', 'result_title' => 'Die innere Stimme der Unabh&auml;ngigen' ],
    ],

];
