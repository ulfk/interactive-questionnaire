jQuery(document).ready(function ($) {
    $('.questionnaire-container[data-questions]').each(function () {
        initQuestionnaire($(this));
    });

    function initQuestionnaire(container) {
        const questions    = container.data('questions');
        const resultTypes  = container.data('resultTypes');

        let currentQuestion = 0;
        let sumOfPoints     = {};

        container.on('click', '.rating-button', function () {
            const value    = parseInt($(this).data('value'));
            const mappings = $(this).data('mappings');

            sumOfPoints[mappings] = (sumOfPoints[mappings] || 0) + value;

            $(this).addClass('selected').siblings('.rating-button').removeClass('selected');

            setTimeout(nextQuestion, 100);
        });

        function nextQuestion() {
            currentQuestion++;
            updateProgress();

            if (currentQuestion >= questions.length) {
                container.find('.questionnaire-questions').hide();
                container.find('.questionnaire-progress-wrapper').hide();
                showResults(getResultsInOrder());
            } else {
                container.find('.questionnaire-question-wrapper').hide();
                container.find('[data-question="' + currentQuestion + '"]').show();
            }
        }

        function updateProgress() {
            const progress = (currentQuestion / questions.length) * 100;
            container.find('.questionnaire-progress-bar').css('width', progress + '%');
        }

        function getResultsInOrder() {
            const totalSum = Math.max(...Object.values(sumOfPoints));
            return Object.entries(sumOfPoints)
                .sort(([, a], [, b]) => b - a)
                .map(([resultId, score]) => {
                    const resultType = resultTypes.find(r => r.result_id === resultId);
                    return {
                        id:         resultId,
                        title:      resultType ? resultType.result_title : resultId,
                        score:      score,
                        percentage: Math.round((score / totalSum) * 100)
                    };
                });
        }

        function showResults(topResults) {
            let html = '<div class="questionaire-results-chart">';
            topResults.forEach(function (result) {
                html +=
                    '<div class="questionaire-results-bar-container">' +
                    '<span class="questionaire-results-bar-label">' + result.title + '</span>' +
                    '<div class="questionaire-results-bar-value" style="width: ' + result.percentage + '%;">' +
                    result.score + ' Punkt' + (result.score > 1 ? 'e' : '') +
                    '</div></div>';
            });
            html += '</div>';
            container.find('.results-content').html(html);
            container.find('.questionnaire-results').show();
        }
    }
});
