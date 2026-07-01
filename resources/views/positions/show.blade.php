<!doctype html>
<html lang="en">

@include('Common.001head')

<?php $readonly = Session::get('readOnlyText') ?>
<?php $disabled = Session::get('disabledText') ?>
<?php $expandPositionHistory = Session::get('ExpandPositionHistory') ?>
<?php $expandIncumbentHistory = Session::get('ExpandIncumbentHistory') ?>

<?php $level1Description = sessionGet('level1Desc') ?>
<?php $level2Description = sessionGet('level2Desc') ?>
<?php $level3Description = sessionGet('level3Desc') ?>
<?php $level4Description = sessionGet('level4Desc') ?>
<?php $level5Description = sessionGet('level5Desc') ?>

<?php $P201Show = sessionGet('P201Show') ?>
<?php $P202Show = sessionGet('P202Show') ?>
<?php $P203Show = sessionGet('P203Show') ?>
<?php $P204Show = sessionGet('P204Show') ?>
<?php $P205Show = sessionGet('P205Show') ?>
<?php $P206Show = sessionGet('P206Show') ?>
<?php $P207Show = sessionGet('P207Show') ?>
<?php $P208Show = sessionGet('P208Show') ?>
<?php $P209Show = sessionGet('P209Show') ?>
<?php $P210Show = sessionGet('P210Show') ?>
<?php $P211Show = sessionGet('P211Show') ?>
<?php $P900Show = sessionGet('P900Show') ?>
<?php $R201Show = sessionGet('R201Show') ?>

<body>
<div class="container-fluid-xxl margin-left: 2; padding-left: 2;">
    <div class="row">
        <div class="row g-2">
            @include('Common.102appnavbar')
        </div>

        <div class="row">
            {{-- Left column: data navbar / position list --}}
            <div class="col-xxl-3 margin-left: 5px">
                <div class="row">
                    <div class="col">
                        @include('positions.Sections.103datanavbar')
                    </div>
                </div>
            </div>

            {{-- Right column: position detail sections --}}
            <div class="col xxl-9 p-5 m-1">
                <div class="row">
                    @include('positions.Sections.101Titles')
                </div>

                <div class="col">

                    <div class="row mb-2">
                        <a class="section-toggle" data-bs-toggle="collapse" data-bs-target="#PosSection1"
                           role="button" aria-expanded="false">
                            Position Status: Currently
                            @if ($position->active=="A") Active, @else Inactive, @endif
                            {{ ucwords(strtolower($position->curstatus)) }}
                        </a>
                        <div class="{{ $P201Show ? 'collapse show' : 'collapse' }}" id="PosSection1">
                            <div class="card card-body">
                                @include('positions.Sections.201Status')
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <a class="section-toggle" data-bs-toggle="collapse" href="#PosSection2"
                           role="button" aria-expanded="false">
                            Budgets and FTEs
                        </a>
                        <div class="{{ $P202Show ? 'collapse show' : 'collapse' }}" id="PosSection2">
                            <div class="card card-body">
                                @include('positions.Sections.202budgets')
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <a class="section-toggle" data-bs-toggle="collapse" href="#PosSection4"
                           role="button" aria-expanded="false">
                            Org Levels
                        </a>
                        <div class="{{ $P204Show ? 'collapse show' : 'collapse' }}" id="PosSection4">
                            <div class="card card-body">
                                @include('positions.Sections.204orglevels')
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <a class="section-toggle" data-bs-toggle="collapse" href="#PosSection5"
                           role="button" aria-expanded="false">
                            Reports To
                        </a>
                        <div class="{{ $P205Show ? 'collapse show' : 'collapse' }}" id="PosSection5">
                            <div class="card card-body">
                                @include('positions.Sections.205reportsto')
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <a class="section-toggle" data-bs-toggle="collapse" href="#PosSection6"
                           role="button" aria-expanded="false">
                            Incumbents
                        </a>
                        <div class="{{ $P206Show ? 'collapse show' : 'collapse' }}" id="PosSection6">
                            <div class="card card-body">
                                @include('positions.Sections.206Incum')
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <a class="section-toggle" data-bs-toggle="collapse" href="#PosSection7"
                           role="button" aria-expanded="false">
                            Position History
                        </a>
                        <div class="{{ $P207Show ? 'collapse show' : 'collapse' }}" id="PosSection7">
                            <div class="card card-body">
                                @include('positions.Sections.207poshist')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>

@include('Common.002script')

</html>
